<?php
namespace App\Models;
use CodeIgniter\Model;
class Payment extends Model {
   protected $table      = 'payments';
    protected $primaryKey = 'id';

    protected $allowedFields = ['firstname', 'lastname', 'address', 'phone', 'email', 'city', 'email', 'amount', 'payment_id'];

    protected $returnType = 'object';
    protected $useSoftDeletes = true;

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField = 'deleted_at';
    protected $dateFormat    = 'datetime';

    protected $validationRules    = [
'amount' => 'required|numeric',
'firstname' => 'required|alpha|max_length[50]|string|alpha',
'lastname' => 'required|alpha|max_length[50]|string|alpha',
'address' => 'required|string',
'city' => 'required|string',
'phone' => 'required|numeric|max_length[15]',
'email' => 'required|valid_email',
'payment_id' => 'required|string|is_unique[payments.payment_id]'
    ];
    protected $validationMessages = [
    'payment_id' => [
    'is_unique' => 'Your payment details already exist on our server.'
    ]
    ];
    protected $skipValidation     = false;
}
?>