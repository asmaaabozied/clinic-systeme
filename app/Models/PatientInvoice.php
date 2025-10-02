<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientInvoice extends Model
{
    protected $table = 'patient_invoices';

    protected $fillable = [
        'appointment_id',
        'patient_id',
        'charge_category_id',
        'charge_id',
        'standardCharge',
        'appliedCharge',
        'discount',
        'tax',
        'amount',
        'payment_method',
        'paidAmount',
        'live_consultation',
        'invoice_no',
        'is_paid',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function chargeCategory()
    {
        return $this->belongsTo(ChargeCategory::class, 'charge_category_id');
    }

    public function charge()
    {
        return $this->hasOne(Charge::class);
    }

    public function items()
    {
        return $this->hasMany(PatientInvoiceItem::class, 'patient_invoice_id');
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
