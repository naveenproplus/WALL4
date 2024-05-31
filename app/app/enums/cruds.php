<?php
namespace App\enums;

enum cruds:string{
    case ADD="Add";
    case VIEW="View";
    case UPDATE="Update";
    case DELETE="Delete";
    case RESTORE="Restore";
}