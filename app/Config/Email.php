<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    public $protocol = 'smtp';
    public $SMTPHost = 'smtp.gmail.com';
    public $SMTPUser = 'appcilogin@gmail.com';
    public $SMTPPass = 'xvrv djls yxhq amhi';
    public $SMTPPort = 465;
    public $SMTPCrypto = 'ssl';
    public $mailType = 'html';
}
