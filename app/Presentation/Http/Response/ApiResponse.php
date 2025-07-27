<?php

namespace App\Presentation\Http\Response;

class ApiResponse
{
    private int $status_code;
    private bool $success;
    private mixed $data = [];
    private array $errors = [];
    private string $message;
    private string $total_rows;
    private string $last_page;

    public function toArray()
    {
        $data = [];

        $data['success'] = $this->success;
        $data['status_code'] = $this->status_code;

        if (!empty($this->data)) {
            $data['data'] = $this->data;
        }

        if (!empty($this->total_rows)) {
            $data['total_rows'] = $this->total_rows;
        }

        if (!empty($this->last_page)) {
            $data['last_page'] = $this->last_page;
        }

        if (!empty($this->errors)) {
            $data['errors'] = $this->errors;
        }

        if (!empty($this->message)) {
            $data['message'] = $this->message;
        }

        return $data;
    }

    public function getData(): mixed
    {
        return $this->data;
    }

    public function setData($data): void
    {
        $this->data = $data;
    }

    public function getStatusCode(): int
    {
        return $this->status_code;
    }

    public function setStatusCode(int $status_code): void
    {
        $this->status_code = $status_code;
    }

    public function getSuccess(): bool
    {
        return $this->success;
    }

    public function setSuccess(bool $success): void
    {
        $this->success = $success;
    }

    public function getError(): array
    {
        return $this->errors;
    }

    public function setError(array $errors): void
    {
        $this->errors = $errors;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function getTotalRows()
    {
        return $this->total_rows;
    }

    public function setTotalRows(string $total_rows): void
    {
        $this->total_rows = $total_rows;
    }

    public function getLastPage(): string
    {
        return $this->last_page;
    }

    public function setLastPage(string $last_page): void
    {
        $this->last_page = $last_page;
    }
}
