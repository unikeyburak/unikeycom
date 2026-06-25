<?php

namespace App\Filament\Resources\PlantResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class NutritionProgramsRelationManager extends RelationManager
{
    protected static string $relationship = 'nutritionPrograms';
    
    protected static ?string $title = 'Besleme Programları';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Program Adı')
                    ->required()
                    ->maxLength(255)
                    ->reactive()
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        if (!empty($state)) {
                            $set('slug', Str::slug($state));
                        }
                    }),
                    
                Forms\Components\TextInput::make('slug')
                    ->label('URL')
                    ->required()
                    ->unique(ignoreRecord: true),
                    
                Forms\Components\Textarea::make('description')
                    ->label('Açıklama')
                    ->rows(3),
                    
                Forms\Components\Select::make('season')
                    ->label('Mevsim')
                    ->options([
                        'İlkbahar' => 'İlkbahar',
                        'Yaz' => 'Yaz',
                        'Sonbahar' => 'Sonbahar',
                        'Kış' => 'Kış',
                        'Tüm Yıl' => 'Tüm Yıl',
                    ]),
                    
                Forms\Components\Select::make('growth_stage')
                    ->label('Büyüme Dönemi')
                    ->options([
                        'Fide' => 'Fide',
                        'Vejetatif' => 'Vejetatif',
                        'Çiçeklenme' => 'Çiçeklenme',
                        'Meyve' => 'Meyve',
                        'Hasat' => 'Hasat',
                    ]),
                    
                Forms\Components\Select::make('application_area')
                    ->label('Uygulama Alanı')
                    ->options([
                        'Yaprak' => 'Yaprak',
                        'Toprak' => 'Toprak',
                        'Damlama' => 'Damlama',
                        'Yaprak + Toprak' => 'Yaprak + Toprak',
                    ]),
                    
                Forms\Components\Toggle::make('is_featured')
                    ->label('Öne Çıkan'),
                    
                Forms\Components\Select::make('status')
                    ->label('Durum')
                    ->options([
                        'active' => 'Aktif',
                        'inactive' => 'Pasif',
                    ])
                    ->default('active'),
            ])
            ->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Program Adı')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('season')
                    ->label('Mevsim')
                    ->badge(),
                    
                Tables\Columns\TextColumn::make('growth_stage')
                    ->label('Dönem')
                    ->badge(),
                    
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Öne Çıkan')
                    ->boolean(),
                    
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Durum')
                    ->colors([
                        'success' => 'active',
                        'danger' => 'inactive',
                    ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Aktif',
                        'inactive' => 'Pasif',
                    ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}