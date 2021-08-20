<?php

namespace DNT\Localization\Controllers;

use App\Http\Controllers\Controller;
use DNT\Localization\Contracts\LocalizationContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChangeLocalizationController extends Controller
{
    /**
     * @var LocalizationContract
     */
    protected $location;

    public function __construct(LocalizationContract $location)
    {
        $this->location = $location;
    }

    public function exampleView()
    {
        $locales = $this->location->localeSupport();
        return view('location::example')->with(['locales' => $locales]);
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function changeLocale(Request $request, string $locale = null)
    {
        if ($request->ajax()) {
            return $this->changeWithAjax($request, $locale);
        }
        abort_if(!$locale, 404);

        $this->validateLocale($locale)->fails();

        $this->change($locale);

        return $this->changeLocaled();
    }

    public function changeLocaled()
    {
        return back();
    }

    public function changeLocaledWithAjax()
    {
        return response([
            'status' => 200,
            'code' => 200,
            'message' => __('Change localization successfully')
        ]);
    }

    protected function changeWithAjax(Request $request, string $locale = null)
    {
        if (!$locale) {
            $locale = $request->get('locale');
        }

        $validator = $this->validateLocale($locale);

        if ($validator->fails()) {
            return response([
                'status' => 422,
                'code' => 422,
                'data' => $validator->errors(),
                'message' => __('Bad request')
            ]);
        }

        $this->change($locale);

        return $this->changeLocaledWithAjax();
    }

    protected function change($locale)
    {
        session([$this->location->getNameAction() => $locale]);
    }

    protected function validateLocale($locale = null): \Illuminate\Contracts\Validation\Validator
    {
        $locales = $this->location->localeSupport();

        return Validator::make(['locale' => $locale], [
            'locale' => 'required|string|in:' . implode(',', $locales)
        ], [
            'locale.required' => __('Locale is required'),
            'locale.string' => __('Locale is string'),
            'locale.in' => __('Locale is not support'),
        ]);
    }
}