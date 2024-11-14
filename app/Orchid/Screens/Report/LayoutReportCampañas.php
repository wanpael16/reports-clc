<?php

namespace App\Orchid\Screens\Report;



use Orchid\Screen\Screen;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\DateRange;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Layout;
use Illuminate\Support\Facades\Validator;

class LayoutReportCampañas extends Screen
{
 
    public function query(): iterable
    {
        return [];
    }

    public function name(): ?string
    {
        return 'Reporte de Campañas';
    }

    public function description(): ?string
    {
        return 'Seleccione el tipo y el rango de fecha de busqueda para generar el reporte.';
    }

    /**
     * The permissions required to access this screen.
     */
    public function permission(): ?iterable
    {
        return [
            'platform.systems.roles',
        ];
    }
    public function commandBar(): iterable
    {
        return [
           
        ];
    }

    public function layout(): iterable
    {
        return [
            layout::rows([
                // Título del reporte
                Select::make('report_type')
                    ->title('Seleccione el tipo de reporte')
                    ->options([
                        'general' => 'Reporte General',
                        'detailed' => 'Reporte Detallado',
                        'summary' => 'Reporte Resumido',
                    ])
                    ->placeholder('Seleccione el tipo de reporte'),

                // Selección de rango de fechas
                DateRange::make('date_range')
                    ->title('Seleccione el rango de fechas')
                    ->placeholder('Seleccione las fechas'),

                // Botón para generar PDF
                Button::make('Generar_PDF')
                    ->method('generatePdf')
                    ->icon('icon-printer')
                    ->confirm('¿Está seguro que desea generar el reporte en PDF?')
            ])

        ];
    }

    public function generatePdf()
    {
      
               // Obtener el rango de fechas
               $dateRange = request()->get('date_range');
               
            
               // Validar si las fechas de inicio y fin están presentes
               $validator = Validator::make(
                   ['start' => $dateRange['start'], 'end' => $dateRange['end']],
                   [
                       'start' => 'required|date',
                       'end' => 'required|date|after_or_equal:start',
                   ],
                   [
                       'start.required' => 'La fecha de inicio es obligatoria.',
                       'end.required' => 'La fecha de fin es obligatoria.',
                       'end.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',
                   ]
               );

               if ($validator->fails()) {
                return back()->withErrors($validator);
            }

               
            $reportType = request()->get('report_type');
            $startDate = $dateRange['start'];
            $endDate = $dateRange['end'];

                return response()->json([
                    'reportType' => $reportType,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                ]);


                // Logica para generar el reporte basado en los datos (ejemplo)
                // Por ejemplo, usando un servicio PDF:
                // $pdf = PDFService::generateReport($reportType, $dateRange);

                // Devuelves el archivo PDF generado
                // return response()->download($pdf);
                
                // Asegúrate de implementar un servicio para la creación de los reportes en PDF.
                // Este es solo un ejemplo general, debes usar tu lógica de negocio.
    }


}
