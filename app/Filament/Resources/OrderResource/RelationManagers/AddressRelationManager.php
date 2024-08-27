<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Tables\Actions\ActionGroup;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AddressRelationManager extends RelationManager
{
    protected static string $relationship = 'address';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('first_name')
                    ->maxLength(255)
                    ->required(),
                TextInput::make('last_name')
                    ->maxLength(255)
                    ->required(),
                TextInput::make('phone')
                    ->tel()
                    ->maxLength(20)
                    ->required(),
                TextInput::make('city')
                    ->required()
                    ->maxLength(255),
                TextInput::make('zip_code')
                    ->numeric()
                    ->maxLength(10)
                    ->required(),
                Textarea::make('street_address')
                    ->required()
                    ->columnSpanFull()

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('street_address')
            ->columns([
                TextColumn::make('full_name')
                    ->label('Full Name'),
                TextColumn::make('phone'),
                TextColumn::make('city'),
                TextColumn::make('zip_code'),
                TextColumn::make('street_address'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
