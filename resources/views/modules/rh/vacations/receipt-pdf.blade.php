<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recibo de vacaciones</title>
    <style>
        @page {
            margin: 30px 40px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #1f2937;
            position: relative;
        }

        .watermark {
            position: fixed;
            top: 20%;
            left: 10%;
            width: 80%;
            text-align: center;
            z-index: -1;
            opacity: 0.08;
        }

        .watermark img {
            width: 100%;
            max-width: 500px;
        }

        .header {
            text-align: center;
            border-bottom: 1px solid #d1d5db;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .title {
            font-size: 22px;
            font-weight: bold;
            margin: 0;
        }

        .subtitle {
            margin: 4px 0 0;
            color: #6b7280;
            font-size: 12px;
        }

        .grid {
            width: 100%;
            border-collapse: collapse;
        }

        .grid td {
            width: 50%;
            vertical-align: top;
            padding: 8px 6px;
        }

        .label {
            font-size: 10px;
            color: #6b7280;
            margin-bottom: 3px;
        }

        .value {
            font-weight: bold;
            font-size: 12px;
        }

        .section {
            margin-top: 15px;
        }

        .legal-box {
            margin-top: 22px;
            padding: 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #f9fafb;
            line-height: 1.6;
            text-align: justify;
        }

        .signature-table {
            width: 100%;
            margin-top: 45px;
        }

        .signature-table td {
            width: 50%;
            text-align: center;
            vertical-align: bottom;
            padding-top: 50px;
        }

        .signature-line {
            border-top: 1px solid #6b7280;
            margin: 0 auto 8px;
            width: 80%;
        }

        .small {
            font-size: 10px;
            color: #6b7280;
        }
    </style>
</head>
<body>

    <div class="watermark">
        <img src="{{ public_path('images/DNLOGO.png') }}" alt="Logo">
    </div>

    <div class="header">
        <p class="title">RECIBO DE VACACIONES</p>
        <p class="subtitle">Registro de periodo vacacional y pago correspondiente</p>
    </div>

    <table class="grid">
        <tr>
            <td>
                <div class="label">Empleado</div>
                <div class="value">{{ $vacation->employee->name }} {{ $vacation->employee->last_name }}</div>
            </td>
            <td>
                <div class="label">Número de empleado</div>
                <div class="value">{{ $vacation->employee->employee_number ?? $vacation->employee->id }}</div>
            </td>
        </tr>
       <tr>
    <td>
        <div class="label">Fecha de ingreso</div>
        <div class="value">
            {{ \Carbon\Carbon::parse($vacation->employee->hire_date)->format('d/m/Y') }}
        </div>
    </td>

    <div class="label">Periodo vacacional correspondiente</div>
<div class="value">
    {{ $vacation->vacation_year == 1 ? 'Primer año' : $vacation->vacation_year . '° Año' }}
</div>
</tr>

<tr>
    <td colspan="2">
        <div class="label">Periodo vacacional</div>
        <div class="value">
            {{ \Carbon\Carbon::parse($vacation->start_date)->format('d/m/Y') }}
            -
            {{ \Carbon\Carbon::parse($vacation->end_date)->format('d/m/Y') }}
        </div>
    </td>
</tr>
        <tr>
            <td>
                <div class="label">Días disponibles</div>
                <div class="value">{{ $vacation->available_days }}</div>
            </td>
            <td>
                <div class="label">Días tomados</div>
                <div class="value">{{ $vacation->taken_days }}</div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="label">Saldo restante</div>
                <div class="value">{{ $vacation->balance_days }}</div>
            </td>
            <td>
                <div class="label">Sueldo diario</div>
                <div class="value">${{ number_format($vacation->salary_daily, 2) }}</div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="label">Pago de vacaciones</div>
                <div class="value">${{ number_format($vacation->vacation_pay, 2) }}</div>
            </td>
            <td>
                <div class="label">Prima vacacional ({{ $vacation->prima_percentage ?? 25 }}%)</div>
                <div class="value">${{ number_format($vacation->prima_vacacional, 2) }}</div>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="label">Total a pagar</div>
                <div class="value" style="font-size:18px; color:#15803d;">
                    ${{ number_format($vacation->total_pay, 2) }}
                </div>
            </td>
        </tr>
    </table>

    <div class="legal-box">
        <strong>DECLARACIÓN:</strong><br>
        Por medio del presente, el colaborador confirma haber solicitado y recibido el pago correspondiente
        a vacaciones y prima vacacional conforme a la Ley Federal del Trabajo.
        Asimismo, manifiesta estar conforme con los días autorizados y el importe recibido.
    </div>

    <table class="signature-table">
        <tr>
            <td>
                <div class="signature-line"></div>
                <div>Firma del empleado</div>
            </td>
            <td>
                <div class="signature-line"></div>
                <div>Firma de Recursos Humanos</div>
            </td>
        </tr>
    </table>

    <p class="small" style="margin-top:20px;">
        Documento generado automáticamente.
    </p>

</body>
</html>