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
     * Çevrilebilir RichEditor oluştur
     */
    public static function makeRichEditor(string $field): Component
    {
        $languages = Language::getActive();
        $defaultLang = Language::getDefault();
        
        if ($languages->count() <= 1) {
            return RichEditor::make($field)
                ->label(ucfirst(str_replace('_', ' ', $field)));
        }
        
        $tabs = [];
        
        foreach ($languages as $language) {
            $tabs[] = Tabs\Tab::make($language->flag . ' ' . $language->name)
                ->schema([
                    RichEditor::make("translations.{$language->code}.{$field}")
                        ->label(ucfirst(str_replace('_', ' ', $field)) . ' (' . $language->name . ')')
                        ->required($language->is_default && $field === 'long_description')
                        ->default(fn ($record) => $record?->translate($field, $language->code, false))
                ]);
        }
        
        return Tabs::make('translations_' . $field)
            ->tabs($tabs)
            ->columnSpanFull();
    }
}