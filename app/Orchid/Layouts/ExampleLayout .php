<?php


use Orchid\Screen\Layouts\Layout;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;

class ExampleLayout extends Layout
{
    public function fields(): array
    {
        return [
            Layout::row([
                Input::make('example.input')
                    ->title('Example Input')
                    ->placeholder('Enter something'),

                TextArea::make('example.textarea')
                    ->title('Example Textarea')
                    ->placeholder('Enter more details'),
            ])
        ];
    }
}