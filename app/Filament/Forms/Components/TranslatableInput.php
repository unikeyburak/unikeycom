<?php

namespace App\Filament\Forms\Components;

use App\Models\Language;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\RichEditor;

class TranslatableInput
{
    /**
     * Çevrilebilir TextInput oluştur
     */
    public static function make(string $field): Component
    {
        $languages = Language::getActive();
        $defaultLang = Language::getDefault();
        
        if ($languages->count() <= 1) {
            return TextInput::make($field)
                ->label(ucfirst(str_replace('_', ' ', $field)));
        }
        
        $tabs = [];
        
        foreach ($languages as $language) {
            $tabs[] = Tabs\Tab::make($language->flag . ' ' . $language->name)
                ->schema([
                    TextInput::make("translations.{$language->code}.{$field}")
                        ->label(ucfirst(str_replace('_', ' ', $field)) . ' (' . $language->name . ')')
                        ->required($language->is_default)
                        ->maxLength(255)
                        ->default(fn ($record) => $record?->translate($field, $language->code, false))
                ]);
        }
        
        return Tabs::make('translations_' . $field)
            ->tabs($tabs)
            ->columnSpanFull();
    }
    
    /**
     * Çevrilebilir Textarea oluştur
     */
    public static function makeTextarea(string $field, int $rows = 3): Component
    {
        $languages = Language::getActive();
        $defaultLang = Language::getDefault();
        
        if ($languages->count() <= 1) {
            return Textarea::make($field)
                ->label(ucfirst(str_replace('_', ' ', $field)))
                ->rows($rows);
        }
        
        $tabs = [];
        
        foreach ($languages as $language) {
            $tabs[] = Tabs\Tab::make($language->flag . ' ' . $language->name)
                ->schema([
                    Textarea::make("translations.{$language->code}.{$field}")
                        ->label(ucfirst(str_replace('_', ' ', $field)) . ' (' . $language->name . ')')
                        ->required($language->is_default && in_array($field, ['short_description']))
                        ->rows($rows)
                        ->default(fn ($record) => $record?->translate($field, $language->code, false))
                ]);
        }
        
        return Tabs::make('translations_' . $field)
            ->tabs($tabs)
            ->columnSpanFull();
    }
    
    /**
     * Herhangi bir bileşeni (Repeater, KeyValue, vb.) dil sekmelerine sar.
     * $factory(string $statePath, string $langCode): Component
     *   - $statePath: çok dilli modda "translations.{code}.{field}", tek dilde "{field}"
     * Dizi/JSON alanlar için kullanılır; kayıt/okuma Create/EditProduct'ta JSON blob olarak yapılır.
     */
    public static function tabbed(string $field, \Closure $factory): Component
    {
        $languages = Language::getActive();

        // Tek dil: doğrudan ana kolona bağla (çeviri katmanı yok, mevcut davranış)
        if ($languages->count() <= 1) {
            $code = optional($languages->first())->code ?? config('app.fallback_locale', 'tr');
            return $factory($field, $code);
        }

        $tabs = [];
        foreach ($languages as $language) {
            $statePath = "translations.{$language->code}.{$field}";
            $tabs[] = Tabs\Tab::make($language->flag . ' ' . $language->name)
                ->schema([ $factory($statePath, $language->code) ]);
        }

        return Tabs::make('translations_' . $field)
            ->tabs($tabs)
            ->columnSpanFull();
    }

    /**
     * tabbed() ile sarılmış bir alanın VARSAYILAN dil sekmesinin state path'i.
     * Paste/aksiyon gibi tek hedefe yazan işlemler bunu kullanır (varsayılan dile yazar).
     */
    public static function defaultStatePath(string $field): string
    {
        $languages = Language::getActive();
        if ($languages->count() <= 1) {
            return $field;
        }
        $code = optional(Language::getDefault())->code ?? config('app.fallback_locale', 'tr');
        return "translations.{$code}.{$field}";
    }

    /**
     * Çevrilebilir RichEditor oluştur
     */
    public static function makeRichEditor(string $field, array $toolbarButtons = []): Component
    {
        $languages = Language::getActive();

        // Özel toolbar verildiyse (ör. features_text: tablo/link) her dile uygula.
        $applyToolbar = fn (RichEditor $editor): RichEditor => empty($toolbarButtons)
            ? $editor
            : $editor->toolbarButtons($toolbarButtons);

        if ($languages->count() <= 1) {
            return $applyToolbar(
                RichEditor::make($field)
                    ->label(ucfirst(str_replace('_', ' ', $field)))
            );
        }

        $tabs = [];

        foreach ($languages as $language) {
            $tabs[] = Tabs\Tab::make($language->flag . ' ' . $language->name)
                ->schema([
                    $applyToolbar(
                        RichEditor::make("translations.{$language->code}.{$field}")
                            ->label(ucfirst(str_replace('_', ' ', $field)) . ' (' . $language->name . ')')
                            ->default(fn ($record) => $record?->translate($field, $language->code, false))
                    ),
                ]);
        }

        return Tabs::make('translations_' . $field)
            ->tabs($tabs)
            ->columnSpanFull();
    }
}