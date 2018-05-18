<?php
/**
 * Custom
 * Quincy Kwende <quincykwende@gmail.com>
 */

namespace App\Http\Requests\Admin;

class AdvertRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => 'required',
            'height' => 'required',
            'width' => 'required',
        ];
    }
}
