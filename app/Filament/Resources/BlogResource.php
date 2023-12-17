<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogResource\Pages;
use App\Filament\Resources\BlogResource\RelationManagers;
use App\Models\{Blog, BlogCategory};
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\Concerns\Translatable;
use Filament\Tables\Columns\SelectColumn;

class BlogResource extends Resource
{
    use Translatable;

    // protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $model = Blog::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function getNavigationLabel(): string
    {
        return trans_choice('News', 1);
    }
    public static function getModelLabel(): string
    {
        return trans_choice('News', 2);
    }

    public static function getPluralModelLabel(): string
    {
        return trans_choice('News', 1);
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Blog manager');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('img')
                    ->label(__('Image'))
                    ->preserveFilenames()
                    ->required()
                    ->directory('images/blog')
                    // ->image()
                    ->imageEditor()
                    ->imageEditorMode(2)
                    ->imageEditorAspectRatios([
                        null,
                        '16:9',
                        '4:3',
                        '1:1',
                    ])
                    ->imageEditorEmptyFillColor('#82AAFF')
                    ->openable()
                    ->downloadable()
                    ->previewable(true)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('alt_img')
                    ->label(__('Alt image'))
                    ->required()
                    ->maxLength(5000),
                Forms\Components\TextInput::make('title')
                    ->label(__('Title'))
                    ->required()
                    ->maxLength(5000),
                Forms\Components\RichEditor::make('desc')
                    ->label(__('Description'))
                    ->required()
                    ->maxLength(1000000)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('order')
                    ->label(__('Order'))
                    ->required()
                    ->numeric()
                    ->maxLength(Blog::count() + 2)
                    ->default(0),
                Forms\Components\DateTimePicker::make('published_at')
                ->label(__('Published at'))
                ->required()
                ->beforeOrEqual(now()),
                Forms\Components\Select::make('category_id')
                ->label(__('Category'))
                ->required()
                ->relationship(name: 'category', titleAttribute: 'title->' . app()->getLocale()),
                Forms\Components\Radio::make('is_active')
                ->required()
                ->label(__('Publish'))
                ->boolean()
                ->inline()
                ->inlineLabel(false)
                ->options([
                    1 => __('Yes'),
                    0 => __('No')
                ])
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label(__('Title'))
                    ->searchable()
                    ->sortable()
                    ->words(10)
                    ->wrap(),
                SelectColumn::make('category_id')
                    ->label(__('Category'))
                    ->options(BlogCategory::pluck('title', 'id'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('views')
                    ->label(__('Views'))
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('order')
                    ->label(__('Order'))
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('published_at')
                    ->label(__('Published at'))
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_viewed_at')
                    ->label(__('Last viewed at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('Updated at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
