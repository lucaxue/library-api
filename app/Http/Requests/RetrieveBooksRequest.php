<?php

namespace App\Http\Requests;

use App\Models\Book\Filters\Filters;
use App\Models\Book\Filters\SearchFilter;
use Illuminate\Foundation\Http\FormRequest;

class RetrieveBooksRequest extends FormRequest
{
    public function filters() : Filters
    {
        $filters = [];

        foreach ($this->except(['page', 'per_page']) as $filter => $value) {
            $filters[] = match ($filter) {
                'search' => new SearchFilter($value),
            };
        }

        return new Filters(...$filters);
    }

    public function rules() : array
    {
        return [
            'search' => ['string'],
            'page' => ['integer'],
            'per_page' => ['integer'],
        ];
    }
}
