<?php

namespace AllanDereal\PesaPal\Enums;

enum ApiEndpoint: string
{
    case REQUEST_TOKEN = '/Auth/RequestToken';
    case REGISTER_IPN = '/URLSetup/RegisterIPN';
    case LIST_IPNS = '/URLSetup/GetIpnList';
    case CREATE_PAYMENT_REQUEST = '/Transactions/SubmitOrderRequest';
    case GET_PAYMENT_REQUEST = '/Transactions/GetTransactionStatus';
    case CANCEL_PAYMENT_REQUEST = '/Transactions/CancelOrder';
    case REQUEST_REFUND = '/Transactions/RefundRequest';
}
