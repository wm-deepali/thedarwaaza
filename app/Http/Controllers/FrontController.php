<?php

namespace App\Http\Controllers;
use App\Models\Category;


class FrontController extends Controller
{
    public function home()
    {

        return view('front-pages.home');
    }


    public function categoryDetail(string $slug)
    {
        $category = Category::where('slug', $slug)
            ->where('status', 1)
            ->with('activeChildren')
            ->firstOrFail();

        // Has sub categories -> show sub category cards
        if ($category->activeChildren->isNotEmpty()) {
            return view('category-detail', compact('category'));
        }

        // No sub categories -> show products
        $products = $category->products()->where('status', 1)->get();

        return view('category-products', compact('category', 'products'));
    }

}