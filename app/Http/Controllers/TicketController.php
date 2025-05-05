<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Requests\TicketRequest;
use Exception;

class TicketController extends Controller
{
    private $messages;

    public function __construct()
    {
        $this->messages = [
            'retrieve_success' => 'Tickets retrieved successfully.',
            'retrieve_failure' => 'Failed to retrieve tickets.',
            'create_success'   => 'Ticket created successfully.',
            'create_failure'   => 'Failed to create ticket.',
            'show_success'     => 'Ticket retrieved successfully.',
            'show_failure'     => 'Failed to retrieve ticket.',
            'update_success'   => 'Ticket updated successfully.',
            'update_failure'   => 'Failed to update ticket.',
            'delete_success'   => 'Ticket deleted successfully.',
            'delete_failure'   => 'Failed to delete ticket.',
            'unexpected_error' => 'An unexpected error occurred.',
            'unexpected_error_query' => 'A database query error occurred.',
            'delete_failure_query' => 'Ticket cannot be deleted due to related data.',
            'pdf_generated_success' => 'PDF generated successfully.',
            'pdf_generated_failure' => 'Failed to generate PDF.'
        ];
    }

    public function index()
    {
        try {
            $tickets = Ticket::with('booking')->get();
            return response()->json([
                'toastmessage' => $this->messages['retrieve_success'],
                'data' => $tickets
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'toastmessage' => $this->messages['retrieve_failure'],
                'error' => $this->messages['unexpected_error'],
                'exception' => $e->getMessage()
            ], 500);
        }
    }

    public function store(TicketRequest $request)
    {
        try {
            Ticket::create($request->validated());
            return response()->json([
                'toastmessage' => $this->messages['create_success']
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'toastmessage' => $this->messages['create_failure'],
                'error' => $this->messages['unexpected_error'],
                'exception' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Ticket $ticket)
    {
        try {
            $ticket->load('booking');
            return response()->json([
                'toastmessage' => $this->messages['show_success'],
                'data' => $ticket
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'toastmessage' => $this->messages['show_failure'],
                'error' => $this->messages['unexpected_error'],
                'exception' => $e->getMessage()
            ], 500);
        }
    }

    public function update(TicketRequest $request, Ticket $ticket)
    {
        try {
            $ticket->update($request->validated());
            return response()->json([
                'toastmessage' => $this->messages['update_success']
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'toastmessage' => $this->messages['update_failure'],
                'error' => $this->messages['unexpected_error'],
                'exception' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Ticket $ticket)
    {
        try {
            $ticket->delete();
            return response()->json([
                'toastmessage' => $this->messages['delete_success']
            ]);
        } catch (\Illuminate\Database\QueryException $queryException) {
            return response()->json([
                'toastmessage' => $this->messages['delete_failure_query'],
                'error' => $this->messages['unexpected_error_query'],
                'exception' => $queryException->getMessage()
            ], 503);
        } catch (Exception $e) {
            return response()->json([
                'toastmessage' => $this->messages['delete_failure'],
                'error' => $this->messages['unexpected_error'],
                'exception' => $e->getMessage()
            ], 500);
        }
    }


        // باقي دوال الـ Controller هنا ...

    /**
     * تحميل التذاكر بتنسيق PDF.
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadPdf()
    {
        try {
            // جلب التذاكر مع تفاصيل الحجز
            $tickets = Ticket::with('booking')->get();

            // تحميل ملف PDF باستخدام الـ View
            $pdf = PDF::loadView('tickets.pdf', compact('tickets'));

            // تحميل الملف كـ PDF
            return $pdf->download('tickets.pdf');
        } catch (\Throwable $e) {
            return response()->json([
                'toastmessage' => $this->messages['pdf_generated_failure'],
                'error' => $this->messages['unexpected_error'],
                'exception' => $e->getMessage()
            ], 500);
        }
    }
}
