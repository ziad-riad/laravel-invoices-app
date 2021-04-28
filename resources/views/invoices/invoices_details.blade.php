@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تفاصيل الفاتوره</span>
						</div>
					</div>
					
				</div>
				<!-- breadcrumb -->
               
@endsection
<!--alerts-->
@section('content')
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


@if (session()->has('Add'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>{{ session()->get('Add') }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
@if(session()->has('delete'))
<div class="alert alert-danger alert-dissmissible fade show" role="alert">
    <strong>{{session()->get('delete')}}</strong>
    <button class="close" type="button" data-dismiss="alert" aria-label="close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

				<!-- row -->
				<div class="row">
                    <!-- Tabs -->
    

                <div class="d-md-flex">
                    <div class="">
                        <div class="panel panel-primary tabs-style-4">
                            <div class="tab-menu-heading">
                                <div class="tabs-menu ">
                                    <!-- Tabs -->
                                    <ul class="nav panel-tabs">
                                        <li class=""><a href="#tab21" class="active" data-toggle="tab"><i class="fa fa-laptop"></i> تفاصيل الفاتوره</a></li>
                                        <li><a href="#tab22" data-toggle="tab"><i class="fa fa-cube"></i> حالة الدفع</a></li>
                                        <li><a href="#tab23" data-toggle="tab"><i class="fa fa-cogs"></i> المرفقات</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tabs-style-4">
                        <div class="panel-body tabs-menu-body">
                            <div class="tab-content">
                                
                                <div class="tab-pane active" id="tab21">
                                    <div class="table-responsive mt-15">
                                        <table class="table table-striped" style="text-align:center">
                                            <tbody>
                                                <tr>
                                                    <th scope="row">رقم الفاتوره</th>
                                                    <td>{{$invoices->invoice_number}}</td>
                                                    <th scope="row">تاريخ الاصدار</th>
                                                    <td>{{$invoices->invoice_date}}</td>
                                                    <th scope="row">تاريخ الااستحقاق</th>
                                                    <td>{{$invoices->due_date}}</td>
                                                    <th scope="row">القسم</th>
                                                    <td>{{$invoices->sections->section}}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">المنتج</th>
                                                    <td>{{$invoices->product}}</td>
                                                    <th scope="row">مبلغ التحصيل</th>
                                                    <td>{{$invoices->Amount_collection}}</td>
                                                    <th scope="row">مبلغ العموله</th>
                                                    <td>{{$invoices->Amount_commission}}</td>
                                                    <th scope="row">الخصم</th>
                                                    <td>{{$invoices->discount}}</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">نسبة الضريبه</th>
                                                    <td>{{$invoices->rate_tax}}</td>
                                                    <th scope="row">قيمة الضريبه </th>
                                                    <td>{{$invoices->value_tax}}</td>
                                                    <th scope="row">الاجمالي</th>
                                                    <td>{{$invoices->total}}</td>
                                                    <th scope="row">الحاله الحاليه</th>
                                                    <td>
                                                        @if ($invoices->value_status == 1)
                                                            <span class="badge badge-pill badge-success">{{$invoices->status}}</span>
                                                        
                                                        @elseif ($invoices->value_status == 2)
                                                            <span class="badge badge-pill badge-danger">{{$invoices->status}}</span>
                                                        @else 
                                                        <span class="badge badge-pill badge-warning">{{$invoices->status}}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                    
                                    
                                    
                                
                                <div class="tab-pane" id="tab22">
                                    <div class="table-responsive mt-15">
                                    <table class="table table-striped" style="text-align:center">
                                    <thead>
                                        <tr>
                                        <th>#</th>
                                        <th>رقم الفاتوره</th>
                                        <th>نوع المنتج</th>
                                        <th>القسم</th>
                                        <th>حالة الدفع</th>
                                        <th>تاريخ الدفع</th>
                                        <th>ملاحظات</th>
                                        <th>تاريخ الاضافه</th>
                                        <th>المستخدم</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i=0;
                                        @endphp
                                    @foreach ($invoices_details as $item)
                                    @php
                                        $i++
                                    @endphp
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$item->invoice_number}}</td>
                                        <td>{{$item->product}}</td>
                                        <td>{{$item->section}}</td>
                                        
                                        
                                            @if ($item->Value_Status == 1)
                                        <td>
                                            <span class="badge badge-pill badge-success">{{$item->Status}}</span>
                                        </td>
                                        @elseif ($item->Value_Status == 2)
                                        <td>
                                            <span class="badge badge-pill badge-danger">{{$item->Status}}</span>
                                        </td>
                                            @else 
                                            <td>
                                        <span class="badge badge-pill badge-warning">{{$item->Status}}</span>
                                        </td>
                                        @endif
                                        
                                        <td>{{$item->Payment_Date}}</td>
                                        <td>{{$item->note}}</td>
                                        <td>{{$item->created_at}}</td>
                                        <td>{{$item->user}}</td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                    </table>
                                    </div>
                                    
                                </div>
                                <div class="tab-pane" id="tab23">
                                    
                                                <form method="post" action="{{ url('/InvoiceAttachments') }}"
                                                    enctype="multipart/form-data">
                                                    {{ csrf_field() }}
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="customFile"
                                                            name="file_name"required>
                                                        <input type="hidden" id="customFile" name="invoice_number"
                                                            value="{{ $invoices->invoice_number }}">
                                                        <input type="hidden" id="invoice_id" name="invoice_id"
                                                            value="{{ $invoices->id }}">
                                                        <label class="custom-file-label" for="customFile">حدد
                                                            المرفق</label>
                                                    </div><br><br>
                                                    <button type="submit" class="btn btn-primary btn-sm "
                                                        name="uploadedFile">تاكيد</button>
                                                </form>
                                            
                                        
                                        <br>
                                    
                                <div class="table-responsive mt-15">
                                    
                                <table class="table table-striped" style="text-align:center">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        
                                        <th>المرفق</th>
                                        <th>تاريخ الاضافه</th>
                                        <th>قام بالاضافه</th>
                                        <th>العمليات</th>
                                        
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i=0;
                                        @endphp
                                    @foreach ($invoice_attachments as $item)
                                    @php
                                        $i++
                                    @endphp
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$item->file_name}}</td>
                                        <td>{{$item->created_at}}</td>
                                        <td>{{$item->created_by}}</td>
                                        <td>
                                            <a href="{{url('view_file')}}/{{$invoices->invoice_number}}/{{$item->file_name}}" class="btn btn-outline-primary btn-sm" role="button">عرض </a>
                                            <a href="{{url('download')}}/{{$invoices->invoice_number}}/{{$item->file_name}}" class="btn btn-outline-secondary btn-sm" role="button">تحميل  </a>
                                            <button class="btn btn-outline-danger btn-sm"
                                            data-toggle="modal"
                                            data-file_name="{{$item->file_name}}"
                                            data-invoice_number="{{$item->invoice_number}}"
                                            data-file_id="{{$item->id}}"
                                            data-target="#delete_file">حذف</button>
                                        </td>
                                        
                                        
                                    </tr>
                                        
                                    @endforeach
                                    </tbody>
                                </table>
                                
                            </div>
                            
                                </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- delete -->
                <div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">حذف المرفق</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{route('delete_file')}}" method="post">
                            
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <h6 style="color: rgb(163, 19, 19)">هل انت متاكد من عملية حذف المرفق ؟</h6><br>
                                <input type="hidden" name="file_name" id="file_name" value="">
                                <input type="hidden" name="file_id" id="file_id" >
                                <input type="hidden" name="invoice_number" id="invoice_number" >
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                <button type="submit" class="btn btn-danger">تاكيد</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    


				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<script>
    $('#delete_file').on('show.bs.modal',function(event){
        var button         = $(event.relatedTarget)
        var file_id        = button.data('file_id')
        var file_name      = button.data('file_name')
        var invoice_number = button.data('invoice_number')
        var modal = $(this)
        
        modal.find('.modal-body #file_id').val(file_id)
        modal.find('.modal-body #file_name').val(file_name)
        modal.find('.modal-body #invoice_number').val(invoice_number)
    })
</script>
@endsection






