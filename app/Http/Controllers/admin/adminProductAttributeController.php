<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class adminProductAttributeController extends Controller
{
    public function index() {
        return view('admin.product_attribute.create');
    }
    public function manage() {
        return view('admin.product_attribute.manage');
    }
}
