<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {   
        if(request()->isMethod('post')){
          return [
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'prix' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'imagePr' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];  
        }else {
            return [
                'titre' => 'required|string|max:255',
                'description' => 'nullable|string',
                'prix' => 'required|numeric',
                'category_id' => 'required|exists:categories,id',
                'imagePr' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ];  
        }
        
    }

    public function messages(){
    
        if(request()->isMethod('post')){
            return [
              'titre.required' => 'titre is required',
              'description.required' => 'description is required ',
              'prix.required' => 'prix is required',
              'category_id.required' => 'categroy is required',
              'imagePr.required' => 'image is required'
          ];  
          }else {
              return [
                'titre.required' => 'titre is required',
                'prix.required' => 'prix is required',
                'category_id.required' => 'categroy is required'
              ];  
          }

    }
}
