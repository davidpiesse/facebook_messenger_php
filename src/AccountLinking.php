<?php
namespace mapdev\FacebookMessenger;

class AccountLinking
{
    public $status;
    public $authorization_code;
    public $linked = false;
    public $unlinked = false;

    /**
     * Delivered constructor.
     * @param $account_linking
     */
    public function __construct($account_linking)
    {
        $this->status = Helper::array_find($account_linking, 'status');
        $this->authorization_code = Helper::array_find($account_linking, 'authorization_code');
        $this->linked = ($this->status == 'linked');
        $this->unlinked = ($this->status == 'unlinked');
    }
}