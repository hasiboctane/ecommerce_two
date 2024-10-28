<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\SubCategory;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Product Information')->schema([
                        Forms\Components\TextInput::make('name')
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(Set $set, string $state) => $set('slug', Str::slug($state)))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('slug')
                            ->disabled()
                            ->dehydrated()
                            ->unique(Product::class,'slug',ignoreRecord:true)
                            ->required()
                            ->maxLength(255),
                        Forms\Components\MarkdownEditor::make('description')
                            ->columnSpanFull()
                            ->fileAttachmentsDirectory('products'),

                    ])->columns(2),
                    Section::make('Images')->schema([
                        Forms\Components\FileUpload::make('images')
                            ->image()
                            ->multiple()
                            ->directory('products')
                            ->maxFiles(5)
                            ->reorderable()
                    ])
                ])->columnSpan(2),
                Group::make()->schema([
                    Section::make('Price')->schema([
                        Forms\Components\TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('BDT'),
                    ]),
                    Section::make('Associations')->schema([
                        Forms\Components\Select::make('parent_category_id')
                            ->relationship('parentCategory', 'name')
                            ->label('Product for')
                            ->required(),
                        Forms\Components\Select::make('category_id')
                            ->label('Category')
                            ->options(Category::query()->pluck('name','id'))
                            ->live()
                            ->reactive(),
                        Forms\Components\Select::make('sub_category_id')
                            ->label('Sub Category')
                            ->options(fn(Get $get): Collection =>SubCategory::query()
                                ->where('category_id', $get('category_id'))
                                ->pluck('name','id')
                            )
                            ->live()
                            ->reactive(),
                        Forms\Components\Select::make('product_type_id')
                            ->label('Product Type')
                            ->options(fn(Get $get): Collection=>ProductType::query()
                                ->where('sub_category_id', $get('sub_category_id'))
                                ->pluck('name','id')
                            )
                            ->reactive(),
                        Forms\Components\Select::make('brand')
                            ->relationship('brand', 'name')
                            ->searchable()
                            ->preload(),
                    ]),
                    Section::make('Status')->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->required()
                            ->default(true),
                        Forms\Components\Toggle::make('is_featured')
                            ->required(),
                        Forms\Components\Toggle::make('in_stock')
                            ->required()
                            ->default(true),
                        Forms\Components\Toggle::make('on_sale')
                            ->required(),
                    ])
                ])->columnSpan(1),

            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('parentCategory.name')
                    ->label("Product for")
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('category.name')
                    ->label("Category")
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('subCategory.name')
                    ->label("Sub Category")
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('productType.name')
                    ->label("Product Type")
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('brand.name')
                    ->label("Brand"),

                Tables\Columns\IconColumn::make('is_active')
                    ->label("Status")
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->boolean(),
                Tables\Columns\IconColumn::make('in_stock')
                    ->boolean(),
                Tables\Columns\IconColumn::make('on_sale')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\Filter::make('In Stock')
                    ->query(fn(Builder $query):Builder => $query->where('in_stock',true)),
                Tables\Filters\Filter::make('Out of Stock')
                    ->query(fn(Builder $query):Builder => $query->where('in_stock',false)),
                Tables\Filters\SelectFilter::make('Product for')
                    ->relationship('parentCategory','name'),
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category','name'),
                Tables\Filters\SelectFilter::make('sub-category')
                    ->relationship('subCategory','name'),
                Tables\Filters\SelectFilter::make('brand')
                    ->relationship('brand','name'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
