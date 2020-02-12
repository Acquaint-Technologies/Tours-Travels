@extends('dashboard::layouts.app')

@section('page_title', $package_type . ' Package')
@if(isset($package->id))
    @section('page_tagline', 'Update '.$package_type.' Package')
@else
    @section('page_tagline', 'Create '.$package_type.' Package')
@endif

@section('content')
    @include('dashboard::msg.message')
    <!--begin::Portlet-->
    <div class="kt-portlet">
        <div class="kt-portlet__head">
            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    @if(isset($package->id)) Update @else Create @endif {{$package_type}} Package
                </h3>
            </div>
        </div>

    @php
        if (isset($package->id)){
            $route = $package_type == 'Hajj' ? route('hajj-package.update', $package->id) : route('omra-hajj-package.update', $package->id);
        }else {
            $route = $package_type == 'Hajj' ? route('hajj-package.store') : route('omra-hajj-package.store');
            $package = new \App\Package();
        }
    @endphp
    <!--begin::Form-->
        <form id="menu-form" action="{{ $route }}" method="POST"
              class="kt-form kt-form--label-right">
            <div class="kt-portlet__body">
                @csrf
                @if(isset($package->id)) @method('PUT') @endif
                <div class="form-group row">
                    <label for="package_name" class="col-2 col-form-label">
                        Package Name *
                    </label>
                    <div class="col-10">
                        <input class="form-control" type="text" id="package_name" name="package_name"
                               value="{{ old('package_name', $package->package_name) }}" placeholder="Package Name" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="pack_code" class="col-2 col-form-label">Package Code *</label>
                    <div class="col-10">
                        <input class="form-control" type="text" id="pack_code" name="pack_code"
                               value="{{ old('pack_code', $package->pack_code) }}" placeholder="Package Code" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="no_of_days" class="col-2 col-form-label">Number of Days *</label>
                    <div class="col-10">
                        <input class="form-control" type="number" id="no_of_days" name="no_of_days"
                               value="{{ old('no_of_days', $package->no_of_days) }}" placeholder="" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="hotel_id" class="col-2 col-form-label text-right">
                        Hotel *</label>
                    <div class="col-10">
                        <select class="form-control kt-selectpicker" data-size="7"
                                data-live-search="true"
                                name="hotel_id" id="hotel_id">
                            @foreach($hotels as $hotel)
                                <option
                                    value="{{ $hotel->id }}"
                                    {{ old('hotel_id', $package->hotel_id) === $hotel->id ? 'selected' : '' }}>
                                    {{ $hotel->hotel_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="vehicle_id" class="col-2 col-form-label text-right">
                        Vehicles *</label>
                    <div class="col-10">
                        <select class="form-control kt-selectpicker" data-size="7"
                                data-live-search="true"
                                name="vehicle_id" id="vehicle_id">
                            @foreach($vehicles as $vehicle)
                                <option
                                    value="{{ $vehicle->id }}"
                                    {{ old('vehicle_id', $package->vehicle_id) === $vehicle->id ? 'selected' : '' }}>
                                    {{ $vehicle->vehicle_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="total_price" class="col-2 col-form-label">Total Price *</label>
                    <div class="col-10">
                        <input class="form-control" type="text" id="total_price" name="total_price"
                               value="{{ old('total_price', $package->total_price) }}" placeholder="">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="status" class="col-2 col-form-label">Status *</label>
                    <div class="col-10">
                        <div class="kt-radio-inline">
                            <label class="kt-radio">
                                <input type="radio" name="status" value="1"
                                    {{(old('status', $package->status) !== 0) ? 'checked' : ''}}>
                                Active
                                <span></span>
                            </label>
                            <label class="kt-radio">
                                <input type="radio" name="status" value="0"
                                    {{(old('status', $package->status) === 0) ? 'checked' : ''}}>
                                Inactive
                                <span></span>
                            </label>
                        </div>
                        <span class="form-text text-muted"></span>
                    </div>
                </div>
                <div class="kt-portlet__foot">
                    <div class="kt-form__actions">
                        <div class="row">
                            <div class="col-2">
                            </div>
                            <div class="col-10">
                                <a href="{{ $package_type == 'Hajj' ? route('hajj-package.index') : route('omra-hajj-package.index') }}" class="btn btn-primary">Cancel</a>
                                <button type="submit" class="btn btn-success">Submit</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!--end::Portlet-->
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#package-management-mm').addClass('kt-menu__item--submenu kt-menu__item--open kt-menu__item--here');
            @if($package_type == 'Hajj')
            $('#add-hajj-package-sm').addClass('kt-menu__item--active');
            @else
            $('#add-omra-hajj-package-sm').addClass('kt-menu__item--active');
            @endif
        });
    </script>
    <!--begin::Page Scripts(used by this page) -->
    <script src="{{ asset('js/pages/package.js') }}" type="text/javascript"></script>

    <!--end::Page Scripts -->
@endpush
