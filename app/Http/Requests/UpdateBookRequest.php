<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
         $bookId = $this->route("id");
         return [
            "cover" => "nullable|file|mimes:jpg,jpeg,png,webp",
            "url"   => "nullable|file|mimes:pdf",
            "title" => "required|string|max:255",
            "slug" => [
            "required",
                Rule::unique('books', 'slug')->ignore($bookId)
            ],
            "description" => "nullable|string",
            "price" => "required|numeric",
            "num_pages" => "nullable|integer",
            "category_id" => "required|exists:categories,id"
        ];
    }


    public function messages(): array
{
    return [
     
        'cover.mimes' => 'La portada debe ser una imagen en formato jpg, jpeg, png o webp.',
        'url.mimes'   => 'El archivo debe ser un PDF.',

        'title.required' => 'El título es obligatorio.',
        'title.string'   => 'El título debe ser una cadena de texto.',
        'title.max'      => 'El título no debe superar los 255 caracteres.',

        'slug.required' => 'El slug es obligatorio.',
        'slug.unique'   => 'El slug ya está en uso, debe ser único.',

        'description.string' => 'La descripción debe ser una cadena de texto.',

        'price.required' => 'El precio es obligatorio.',
        'price.numeric'  => 'El precio debe ser un valor numérico.',

        'url.required' => 'La URL es obligatoria.',

        'num_pages.integer' => 'El número de páginas debe ser un número entero.',

        'category_id.required' => 'La categoría es obligatoria.',
        'category_id.exists'   => 'La categoría seleccionada no existe.',
    ];
}
}
