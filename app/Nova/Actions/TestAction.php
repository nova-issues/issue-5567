<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class TestAction extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Text::make(__('Test input'), 'test'),
            Text::make(__('Result'), 'result')
                ->dependsOn('test', function (Text $field, NovaRequest $request, FormData $form) {
                    if ($request->allResourcesSelected()) {
                        $field->setValue($form->get('test').' - All selected');
                    } else {
                        $field->setValue($form->get('test').' - '.$request->selectedResourceIds()->join(', ', ' and '));
                    }

                    $field->setValue($form->get('test'));
                }),
        ];
    }
}
