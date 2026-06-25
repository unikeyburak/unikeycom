<?php

namespace App\Http\Traits;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasFaq
{
    /**
     * Polymorphic FAQ ilişkisi
     */
    public function faqs(): MorphMany
    {
        return $this->morphMany(Faq::class, 'faqable');
    }

    /**
     * Aktif FAQ'ları getir
     */
    public function activeFaqs(): MorphMany
    {
        return $this->faqs()->active()->ordered();
    }

    /**
     * FAQ Schema verilerini al
     */
    public function getFaqSchemaData(): array
    {
        $questions = [];
        
        foreach ($this->activeFaqs as $faq) {
            $questions[] = $faq->toSchemaFormat();
        }
        
        return ['questions' => $questions];
    }

    /**
     * FAQ ekle
     */
    public function addFaq(string $question, string $answer, int $sortOrder = 0): Faq
    {
        return $this->faqs()->create([
            'question' => $question,
            'answer' => $answer,
            'sort_order' => $sortOrder,
            'is_active' => true
        ]);
    }

    /**
     * Otomatik FAQ'ları oluştur (override edilebilir)
     */
    public function generateAutoFaqs(): void
    {
        // Alt sınıflar tarafından override edilecek
    }
}