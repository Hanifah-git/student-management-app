<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        if ($this->method() == "POST") {
            return [
                // for multi post this must be array
                'post_id' => 'required|array',
                // all selected posts must exist 
                'post_id.*' => 'exists:posts,id',
                'startdate' => 'required|date',
                'enddate' => 'required|date|after_or_equal:startdate',
                // for multi post this must be array
                'tag' => 'required|array',
                // all selected posts must exist 
                'tag.*' => 'exists:users,id',
                'title' => 'required|max:100',
                'content' => 'required',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:1024',
                'images' => 'nullable|array',
                'images.*' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:1024'
            ];
        } else {
            return [
                // for multi post this must be array
                'post_id' => 'required|array',
                // all selected posts must exist 
                'post_id.*' => 'exists:posts,id',
                'startdate' => 'required|date',
                'enddate' => 'required|date|after_or_equal:startdate',
                // for multi post this must be array
                'tag' => 'required|array',
                // all selected posts must exist 
                'tag.*' => 'exists:users,id',
                'title' => 'required|max:100',
                'content' => 'required',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:1024',
                'images.*' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:1024'
            ];
        }

    }
}

// php artisan make:request LeaveRequest
