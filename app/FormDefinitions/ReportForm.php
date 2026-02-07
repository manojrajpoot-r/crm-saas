<?php

namespace App\FormDefinitions;
use App\Models\Tenant\Project;
class ReportForm
{
    public static function fields($item = null): array
    {
        return [

            'Report Type' => [

                [
                    'type'  => 'radio',
                    'label' => 'Report Type',
                    'name'  => 'report_type',
                    'options' => [
                        'project' => 'With Project',
                        'other'   => 'Other',
                    ],
                    'value' => $item
                        ? ($item->project_id ? 'project' : 'other')
                        : 'project',
                ],



                [
                    'type' => 'select',
                    'label' => 'Project',
                    'name' => 'project_id',
                    'options' => Project::pluck('name', 'id')->toArray(),
                    'placeholder' => 'Select Project',
                    'value' => $item->project_id ?? '',
                    'extra' => [
                        'id' => 'projectSelect'
                    ],
                ],


                [
                    'type' => 'input',
                    'label' => 'Other Project Title',
                    'name' => 'other_project_title',
                    'type_attr' => 'text',
                    'value' => $item->other_project_title ?? '',
                    'wrapper' => 'otherProjectWrapper',
                ],

                [
                    'type' => 'input',
                    'label' => 'Report Title',
                    'name' => 'title',
                    'type_attr' => 'text',
                    'value' => $item->title ?? '',
                    'required' => true,
                ],

                [
                    'type' => 'input',
                    'label' => 'Report Date',
                    'name' => 'report_date',
                    'type_attr' => 'date',
                    'value' => $item->report_date ?? now()->format('Y-m-d'),
                    'required' => true,
                ],

                [
                    'type' => 'textarea',
                    'label' => 'Report Description',
                    'name' => 'description',
                    'value' => $item->description ?? '',
                ],
            ],

        ];
    }
}