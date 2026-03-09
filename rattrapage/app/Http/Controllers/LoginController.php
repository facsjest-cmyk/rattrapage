<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Planing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function showForm()
    {
        return view('login');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('cod_etu');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'code_apogee' => ['required', 'string'],
                'date_naissance' => [
                    'required',
                    'string',
                    function (string $attribute, mixed $value, \Closure $fail): void {
                        if (! is_string($value) || $this->parseDobToYmd($value) === null) {
                            $fail(__('messages.login.errors.dob_invalid_format'));
                        }
                    },
                ],
            ],
            [
                'code_apogee.required' => __('messages.login.errors.code_required'),
                'date_naissance.required' => __('messages.login.errors.dob_required'),
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $codeApogee = (string) $request->input('code_apogee');
        $dobInput = (string) $request->input('date_naissance');

        $dobYmd = $this->parseDobToYmd($dobInput);

        $etudiant = Planing::query()
            ->where('cod_etu', $codeApogee)
            ->whereDate('date_nai_ind', $dobYmd)
            ->first();

        if ($etudiant === null) {
            return back()->withErrors([
                'date_naissance' => __('messages.login.errors.dob_mismatch'),
            ])->withInput();
        }

        $request->session()->put('cod_etu', $etudiant->cod_etu);
        $request->session()->regenerate();

        return redirect('/convocation');
    }

    private function parseDobToYmd(string $value): ?string
    {
        $formats = ['d/m/Y', 'd-m-Y', 'Y-m-d'];

        foreach ($formats as $format) {
            $dt = DateTime::createFromFormat($format, $value);
            $errors = DateTime::getLastErrors();

            $hasErrors =
                $dt === false ||
                ($errors !== false && ($errors['warning_count'] > 0 || $errors['error_count'] > 0)) ||
                ($dt !== false && $dt->format($format) !== $value);

            if (! $hasErrors && $dt !== false) {
                return $dt->format('Y-m-d');
            }
        }

        return null;
    }
}
