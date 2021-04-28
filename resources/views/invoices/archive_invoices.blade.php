@extends('layouts.master')
@section('title')
أرشيف الفواتير 
@stop
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<!--Internal notify -->
<link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/قائمة الأرشفه</span>
						</div>
					</div>
					<div class="d-flex my-xl-auto right-content">
						<div class="pr-1 mb-3 mb-xl-0">
							<button type="button" class="btn btn-info btn-icon ml-2"><i class="mdi mdi-filter-variant"></i></button>
						</div>
						<div class="pr-1 mb-3 mb-xl-0">
							<button type="button" class="btn btn-danger btn-icon ml-2"><i class="mdi mdi-star"></i></button>
						</div>
						<div class="pr-1 mb-3 mb-xl-0">
							<button type="button" class="btn btn-warning  btn-icon ml-2"><i class="mdi mdi-refresh"></i></button>
						</div>
						<div class="mb-3 mb-xl-0">
							<div class="btn-group dropdown">
								<button type="button" class="btn btn-primary">14 Aug 2019</button>
								<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" id="dropdownMenuDate" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="sr-only">Toggle Dropdown</span>
								</button>
								<div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuDate" data-x-placement="bottom-end">
									<a class="dropdown-item" href="#">2015</a>
									<a class="dropdown-item" href="#">2016</a>
									<a class="dropdown-item" href="#">2017</a>
									<a class="dropdown-item" href="#">2018</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				@if (session()->has('delete_invoice'))
				<script>
					window.onload = function() {
						notif({
							msg: "تم حذف الفاتورة بنجاح",
							type: "success"
						})
					}
				</script>
				@endif
				<!-- row -->
				<div class="row">
					
						<div class="col-xl-12">
							<div class="card">
								<div class="card-header pb-0">
									<div class="d-flex justify-content-between">
										<h4 class="card-title mg-b-0">الفاتوره</h4>
										<i class="mdi mdi-dots-horizontal text-gray"></i>
									</div>
									<div class="col-sm-6 col-md-4 col-xl-3 mg-t-20">
										<a href="invoices/create" class="modal-effect btn btn-sm btn-primary" style="color:white"><i
											class="fas fa-plus"></i>&nbsp; اضافة فاتورة</a>
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table class="table text-md-nowrap" id="example1">
											<thead>
												<tr>
													<th class="wd-15p border-bottom-0">#</th>
													<th class="wd-15p border-bottom-0">رقم الفاتوره</th>
													<th class="wd-20p border-bottom-0">تاريخ الفاتوره</th>
													<th class="wd-15p border-bottom-0">تاريخ الااستحقاق</th>
													<th class="wd-10p border-bottom-0">القسم</th>
													<th class="wd-25p border-bottom-0">المنتج</th>
													<th class="wd-25p border-bottom-0">الخصم</th>
													<th class="wd-25p border-bottom-0">نسبة الضريبه</th>
													<th class="wd-25p border-bottom-0">قيمة الضريبه</th>
													<th class="wd-25p border-bottom-0"> الاجمالي</th>
													<th class="wd-25p border-bottom-0">الحاله</th>
													<th class="wd-25p border-bottom-0">الملاحظات</th>
													<th class="wd-25p border-bottom-0">العمليات</th>
													
												</tr>
											</thead>
											<tbody>
												@php
													$i = 0;
												@endphp
												@foreach ($invoices as $item)
													
												@php
													$i++;
												@endphp
												<tr>
													<td>{{$i}}</td>
													<td>{{$item->invoice_number}}</td>
													<td> {{$item->invoice_date}}</td>
													<td>{{$item->due_date}}</td>
													<td><a href="{{url('InvoicesDetails')}}/{{$item->id}}">{{$item->sections->section}}</a></td>
													<td>{{$item->product}}</td>
													<td>{{$item->discount}}</td>
													<td>{{$item->rate_tax}}</td>
													<td>{{$item->value_tax}}</td>
													<td>{{$item->total}}</td>
													<td>
														@if ($item->value_status == 1)
														<span class="text-success">{{$item->status}}</span>
														@elseif($item->value_status == 2)
														<span class="text-danger">{{$item->status}}</span>
														@else
														<span class="text-warning">{{$item->status}}</span>
														@endif
													</td>
													<td>{{$item->note}}</td>
													<td>
														<div class="dropdown">
															<button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-primary"
															data-toggle="dropdown" type="button"> العمليات <i class="fas fa-caret-down ml-1" ></i></button>
															<div class="dropdown-menu tx-13">
																
																<a class="dropdown-item" href="#" data-invoice_id="{{$item->id}}"
																	data-toggle="modal" data-target="#delete_invoice"><i
																		class="text-danger fas fa-trash-alt"></i>&nbsp;&nbsp;حذف
																	الفاتورة</a>

																	<a class="dropdown-item" href="#" data-invoice_id="{{$item->id}}"
																		data-toggle="modal" data-target="#transfer_invoice"><i
																		class="fas fa-archive" style="color: rgb(241, 160, 174)"></i>&nbsp;&nbsp;  اٍلغاء أرشفة الفاتوره</a>
																	<a class="dropdown-item" href="#"><></i>&nbsp;&nbsp;</a>


															</div>
														</div>
														
													</td>
												</tr>
												@endforeach
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<!--/حذف الفاتوره -->
						<div class="modal fade" id="delete_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
						aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">حذف الفاتورة</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
									<form action="{{ route('Archive.destroy', 'test') }}" method="post">
										{{ method_field('delete') }}
										{{ csrf_field() }}
								</div>
								<div class="modal-body">
									هل انت متاكد من عملية الحذف ؟
									<input type="hidden"  name="invoice_id" id="invoice_id" value="">
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
									<button type="submit" class="btn btn-danger">تاكيد</button>
								</div>
								</form>
							</div>
						</div>
					</div>

                    <div class="modal fade" id="transfer_invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
						aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">الغاء عملية ارشفة الفاتورة</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
									<form action="{{ route('Archive.update','test') }}" method="POST">
										{{ method_field('patch') }}
										{{ csrf_field() }}
								</div>
								<div class="modal-body">
									هل انت متاكد من عملية اٍلغاء الأرشفه ؟
									<input type="text"  name="invoice_id" id="invoice_id" value="">
                                    
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
									<button type="submit" class="btn btn-success">تاكيد</button>
								</div>
								</form>
							</div>
						</div>
					</div>
				
	
						<!--div-->
					
						<!--/div-->
	
						<!--div-->
						
						<!--/div-->
	
						<!--div-->
						
					</div>
				
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
<!--Internal  Notify js -->
<script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
<script>
	
		$('#delete_invoice').on('show.bs.modal',function(event){
		var button     = $(event.relatedTarget)
		var invoice_id = button.data('invoice_id')
		var modal = $(this)

		modal.find('.modal-body #invoice_id').val(invoice_id);
	})
</script>
<script>
	
    $('#transfer_invoice').on('show.bs.modal',function(event){
    var button     = $(event.relatedTarget)
    var invoice_id = button.data('invoice_id')
    var modal = $(this)

    modal.find('.modal-body #invoice_id').val(invoice_id);
})
</script>
@endsection