<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientInvoiceItem extends Model
{
    protected $fillable = [
        'patient_invoice_id',
        'charge_id',
        'standard_charge',
        'applied_charge',
        'discount',
        'tax',
        'amount',
    ];

    public function invoice()
    {
        return $this->belongsTo(PatientInvoice::class, 'patient_invoice_id');
    }

    public function charge()
    {
        return $this->belongsTo(Charge::class);
    }
}
