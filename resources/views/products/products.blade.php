@extends('layouts.master')
@section('title')
المنتجات
@stop
@section('css')
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الاٍعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ المنتجات</span>
						</div>
					</div>
					
				</div>
				<!-- breadcrumb -->
@endsection
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

@if(session()->has('Error'))
<div class="alert alert-danger alert-dissmissible fade show" role="alert">
	<strong>{{session()->get('Error')}}</strong>
	<button class="close" type="button" data-dismiss="alert" aria-label="close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
@endif
@if(session()->has('edit'))
<div class="alert alert-success alert-dissmissible fade show" role="alert">
	<strong>{{session()->get('edit')}}</strong>
	<button class="close" type="button" data-dismiss="alert" aria-label="close">
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
					<div class="col-xl-12">
						<div class="card">
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
									<h4 class="card-title mg-b-0">الفاتوره</h4>
									<i class="mdi mdi-dots-horizontal text-gray"></i>
								</div>
								@can('اضافة منتج')
								<div class="col-sm-6 col-md-4 col-xl-3 mg-t-20">
									<a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-rotate-left" data-toggle="modal" href="#exampleModal">اضافة منتج +</a>
								</div>
								@endcan
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table text-md-nowrap" id="example1" data-page-length='50'>
										<thead>
											<tr>
												<th class="wd-15p border-bottom-0">#</th>
												<th class="wd-15p border-bottom-0">اسم المنتج</th>
												<th class="wd-20p border-bottom-0">اسم القسم</th>
												<th class="wd-25p border-bottom-0">الملاحظات</th>
												<th class="wd-25p border-bottom-0">العمليات</th>
											</tr>
										</thead>
										<tbody>
											<?php $i = 0 ?>
											@foreach ($products as $item)
												<?php $i++; ?>
											
											<tr>
												<td>{{$i}}</td>
												<td>{{$item->product_name}}</td>
												<td>{{$item->sections->section}}</td>
												<td>{{$item->description}}</td>
												<td>
													@can('تعديل منتج')
													<button class="btn btn-outline-success btn-sm"
													data-name="{{ $item->product_name }}" data-pro_id="{{ $item->id }}"
													data-section="{{ $item->sections->section }}"
													data-description="{{ $item->description }}" data-toggle="modal"
													data-target="#edit_product">تعديل</button>
													@endcan
													
													@can('حذف منتج')
													<button class="btn btn-outline-danger btn-sm " data-pro_id="{{ $item->id }}"
													data-product_name="{{ $item->product_name }}" data-toggle="modal"
													data-target="#modaldemo9">حذف</button>
													@endcan
												</td>
												
											</tr>
											@endforeach
											
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<!--  add -->
					<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">اضافة منتج</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                    <form action={{route('products.store')}} method="post">
                                    {{csrf_field()}}
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">اسم المنتج</label>
                                            <input type="text" class="form-control" id="product_name" name="product_name"  >

                                        </div>

                                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">القسم</label>
                                        <select name="section_id" id="section_id" class="form-control" required>
                                            <option value="" selected disabled> --حدد القسم--</option>
                                            @foreach ($sections as $section)
                                                <option value="{{ $section->id }}">{{ $section->section }}</option>
                                            @endforeach
                                        </select>

                                        <div class="form-group">
                                            <label for="exampleFormControlTextarea1">ملاحظات</label>
                                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">تاكيد</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
				</div>
				<!-- edit -->
				<div class="modal fade" id="edit_product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
				aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">تعديل منتج</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form action='products/update' method="post">
							{{ method_field('patch') }}
							{{ csrf_field() }}
							<div class="modal-body">
	
								<div class="form-group">
									<label for="title">اسم المنتج :</label>
	
									<input type="hidden" class="form-control" name="pro_id" id="pro_id" value="">
	
									<input type="text" class="form-control" name="product_name" id="product_name">
								</div>
	
								<label class="my-1 mr-2" for="inlineFormCustomSelectPref">القسم</label>
								<select name="section" id="section" class="custom-select my-1 mr-sm-2" required>
									@foreach ($sections as $section)
										<option>{{ $section->section }}</option>
									@endforeach
								</select>
	
								<div class="form-group">
									<label for="des">ملاحظات :</label>
									<textarea name="description" cols="20" rows="5" id='description'
										class="form-control"></textarea>
								</div>
	
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn btn-primary">تعديل البيانات</button>
								<button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			 <!-- delete -->
			 <div class="modal fade" id="modaldemo9" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
			 aria-hidden="true">
			 <div class="modal-dialog" role="document">
				 <div class="modal-content">
					 <div class="modal-header">
						 <h5 class="modal-title">حذف المنتج</h5>
						 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							 <span aria-hidden="true">&times;</span>
						 </button>
					 </div>
					 <form action="products/destroy" method="post">
						 {{ method_field('delete') }}
						 {{ csrf_field() }}
						 <div class="modal-body">
							 <p>هل انت متاكد من عملية الحذف ؟</p><br>
							 <input type="hidden" name="pro_id" id="pro_id" value="">
							 <input class="form-control" name="product_name" id="product_name" type="text" readonly>
						 </div>
						 <div class="modal-footer">
							 <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
							 <button type="submit" class="btn btn-danger">تاكيد</button>
						 </div>
					 </form>
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
<!-- Internal Data tables -->
<script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
    <!-- Internal Prism js-->
    <script src="{{ URL::asset('assets/plugins/prism/prism.js') }}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!-- Internal Modal js-->
<script src="{{ URL::asset('assets/js/modal.js') }}"></script>
<script>
	$('#edit_product').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var product_name = button.data('name')
		var section = button.data('section')
		var pro_id = button.data('pro_id')
		var description = button.data('description')
		var modal = $(this)
		modal.find('.modal-body #product_name').val(product_name);
		modal.find('.modal-body #section').val(section);
		modal.find('.modal-body #description').val(description);
		modal.find('.modal-body #pro_id').val(pro_id);
	})
	$('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var pro_id = button.data('pro_id')
            var product_name = button.data('product_name')
            var modal = $(this)

            modal.find('.modal-body #pro_id').val(pro_id);
            modal.find('.modal-body #product_name').val(product_name);
        })
</script>

@endsection