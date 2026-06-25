<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use App\Models\NutritionProgram;
use Illuminate\Http\Request;

class NutritionProgramController extends Controller
{
    /**
     * Tüm bitkiler listesi
     */
    public function index()
    {
        $plants = Plant::active()
            ->withCount('nutritionPrograms')
            ->having('nutrition_programs_count', '>', 0)
            ->orderBy('sort_order')
            ->paginate(24);

        return view('nutrition-programs.index', compact('plants'));
    }

    /**
     * Belirli bir bitkinin programları
     */
    public function plant(Plant $plant)
    {
        // Bitkiye ait programları getir
        $programs = $plant->nutritionPrograms()
            ->with(['benefits', 'stages.products.product'])
            ->active()
            ->get();

        // İlgili diğer bitkiler
        $relatedPlants = Plant::active()
            ->where('id', '!=', $plant->id)
            ->withCount('nutritionPrograms')
            ->having('nutrition_programs_count', '>', 0)
            ->limit(6)
            ->get();

        return view('nutrition-programs.plant', compact('plant', 'programs', 'relatedPlants'));
    }

    /**
     * Program detayı
     */
    public function show(Plant $plant, NutritionProgram $program)
    {
        // İlişkili verileri yükle
        $program->load(['plant', 'benefits', 'stages.products.product']);

        // Diğer programlar
        $otherPrograms = $plant->nutritionPrograms()
            ->where('id', '!=', $program->id)
            ->active()
            ->get();

        return view('nutrition-programs.show', compact('plant', 'program', 'otherPrograms'));
    }

    /**
     * Program ürünleri
     */
    public function products(NutritionProgram $program)
    {
        $program->load(['plant', 'stages.products.product']);

        return view('nutrition-programs.products', compact('program'));
    }
}