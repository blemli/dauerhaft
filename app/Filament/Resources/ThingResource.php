<?php

namespace App\Filament\Resources;
use App\Filament\Resources\ThingResource\Pages;
use App\Models\Thing;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use File;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;
use function str_replace;

class ThingResource extends Resource
{
    protected static ?string $model = Thing::class;

    protected static ?string $slug = 'things';

    //title attribute for the resource (label)
    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getPluralModelLabel(): string
    {
        return __('things');
    }

    public static function getModelLabel(): string
    {
        return __('thing');
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Placeholder::make('created_at')
                    ->label('Created Date')
                    ->content(fn(?Thing $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                Placeholder::make('updated_at')
                    ->label('Last Modified Date')
                    ->content(fn(?Thing $record): string => $record?->updated_at?->diffForHumans() ?? '-'),

                TextInput::make('name')
                    ->required(),

                Textarea::make('description'),
                Textarea::make('picture')
                    ->required(),

                TextInput::make('price')
                    ->numeric()->prefix('CHF')->numeric()   ->mask(RawJs::make('$money($input)')),

                DatePicker::make('buy_date')->default( now() ),

                DatePicker::make('death_date'),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->paginated(false)
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('picture')
                    ->formatStateUsing(fn (string $state): HtmlString =>
                    new HtmlString(
                        str_replace(
                            ['<svg', 'height="auto"'],
                            ['<svg height="30pt" width="auto"', ''],
                            $state
                        )
                    )),

                TextColumn::make('description')
                    ->searchable()->toggleable()->toggledHiddenByDefault(true),

                TextColumn::make('price')
                    ->sortable(),

                TextColumn::make('buy_date')
                    ->date()
                    ->sortable(),

                TextColumn::make('death_date')
                    ->date()
                    ->sortable(),


                TextColumn::make('months_alive')
                    ->sortable(),

                TextColumn::make('price_per_day')
                    ->sortable()->prefix('CHF ')->numeric(),
            ])
            ->filters([
                TrashedFilter::make(),
                //Alive Filter
                TernaryFilter::make('alive')
                    ->label('Alive')->boolean()
                    ->placeholder('All Things')->trueLabel('Dead')->falseLabel('Alive')
            ->queries(
                true: fn (Builder $query) => $query->whereNotNull('death_date'),
                false: fn (Builder $query) => $query->whereNull('death_date'),
                blank: fn (Builder $query) => $query, // In this example, we do not want to filter the query when it is blank.
            )


            ])
            ->actions([
                Action::make('dead')
                    ->label('Mark Dead')
                    ->requiresConfirmation('Are you sure you want to mark this thing as dead?')
                    ->action(fn (Thing $record) => $record->markAsDead())
                    ->visible(fn (Thing $record) => $record->alive)
                    ->icon('tabler-coffin'),
                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
                ForceDeleteAction::make(),


            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    BulkAction::make('mark_dead')
                        ->label('Mark Dead')
                        ->requiresConfirmation('Are you sure you want to mark these things as dead?')
                        ->action(function (array $records) {
                            Thing::whereIn('id', $records)  // Use $records directly to filter the IDs
                            ->where('alive', true) // Ensure you only mark alive records
                            ->get()
                                ->each(function ($thing) {
                                    $thing->markAsDead(); // Mark each record as dead
                                });
                        })
                        ->icon('tabler-coffin')
            ])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListThings::route('/'),
            'create' => Pages\CreateThing::route('/create'),
            'edit' => Pages\EditThing::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }
}
