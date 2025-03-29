<?php

namespace App\Exports;

use App\Models\Customer;
use App\Models\QuestionOptionUser;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;

class CustomerQuizExport implements FromCollection, WithHeadings, WithMapping, WithEvents, WithColumnWidths
{
    public function collection()
    {
        $tmp = [];
        $data = [];
        $data =  QuestionOptionUser::select('question_option_users.*', 'customers.name', 'customer_categories.title as customer_categories_title', 'quizzes.title as quizzes_title', 'quizzes.time as time')
            ->join('customers', 'customers.id', '=', 'question_option_users.customer_id')
            ->join('customer_categories', 'customer_categories.id', '=', 'customers.catalogue_id')
            ->join('quizzes', 'quizzes.id', '=', 'question_option_users.quiz_id');
        if (!empty($_GET['keyword'])) {
            $keyword = $_GET['keyword'];
            if (!empty($keyword)) {
                $data = $data->where(function ($query) use ($keyword) {
                    $query->where('quizzes.title', 'like', '%' . $keyword . '%');
                });
            }
        }
        if (!empty($_GET['customer_id'])) {
            $customer_id = $_GET['customer_id'];
            if (!empty($customer_id)) {
                $data = $data->where(function ($query) use ($customer_id) {
                    $query->where('question_option_users.customer_id', $customer_id);
                });
            }
        }
        if (!empty($_GET['customer_categories_id'])) {
            $customer_categories_id = $_GET['customer_categories_id'];
            $data = $data->where(function ($query) use ($customer_categories_id) {
                $query->where('customer_categories.id', $customer_categories_id);
            });
        }
        if (!empty($_GET['quiz_id'])) {
            $quiz_id = $_GET['quiz_id'];
            $data = $data->where(function ($query) use ($quiz_id) {
                $query->where('quizzes.id', $quiz_id);
            });
        }
        $data =  $data->where('type', 'first')->orderBy('id', 'desc')->get();
        $tmp = [];
        if (!empty($data)) {
            foreach ($data as $key => $item) {
                $tmp[] = [
                    'stt' => $key + 1,
                    'quizzes_title' => $item->quizzes_title,
                    'name' => $item->customer->name,
                    'school' => $item->customer->school,
                    'level' => !empty($item->customer->level) ? $item->customer->level : '',
                    'class' => $item->customer->customer_categories->title,
                    'status' =>  $item->status,
                    'time' => $item->time,
                    'timer' => $item->timer,
                    'created_at' => $item->created_at,
                    'pause' => $item->pause,
                ];
            }
        }
        $tmp = collect($tmp);
        return $tmp;
    }
    public function headings(): array
    {
        return [
            'STT',
            'Đề thi',
            'Họ và tên',
            'Trường học',
            'Cấp bậc',
            'Lớp',
            'Điểm',
            'Thời gian',
            'Nộp bài',
            'Số lần tạm dừng',
        ];
    }
    public function map($row): array
    {
        if ($row['status'] == 'wait') {
            $status = 'Chưa chấm';
        } else {
            $status = 'Đã chấm';
        }
        $timer = '';
        $time = (int)$row['time'] * 60 - (int)$row['timer'];
        $hours = ((int)$time / 3600) % 24;
        $minutes = ((int) $time / 60) % 60;
        $seconds = $time % 60;
        if ($hours > 0) {
            $timer = ($hours < 10 ? "0" . $hours : $hours) . 'giờ' . ($minutes < 10 ? "0" . $minutes : $minutes) . 'phút' .  ($seconds < 10 ? "0" . $seconds : $seconds)  . 'giây';
        } else {
            $timer = ($minutes < 10 ? "0" . $minutes : $minutes) . 'phút' . ($seconds < 10 ? "0" . $seconds : $seconds) . "giây";
        }
        return [
            $row['stt'],
            $row['quizzes_title'],
            $row['name'],
            $row['school'],
            $row['level'],
            $row['class'],
            $status,
            $timer,
            $row['created_at'],
            !empty($row['pause']) ? $row['pause'] : 0,
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $cellRange = 'A1:J1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FF17a2b8');
                $event->sheet->setAutoFilter($cellRange);
            },
        ];
    }
    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 25,
            'C' => 45,
            'D' => 25,
            'E' => 25,
            'F' => 25,
            'G' => 25,
            'H' => 25,
            'I' => 25,
            'J' => 25,
        ];
    }
}
