@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.settings.page_title.index')}}
@endsection
@section('breadcrumbs')
    <span class="kt-subheader__breadcrumbs-separator"></span>
    <a href="{{route('settings.index')}}" class="kt-subheader__breadcrumbs-link">
        {{__('app.settings.page_title.index')}} </a>
@endsection
@section('content')
    @push('css')
        <meta name="csrf-token" content="{{ csrf_token() }}">
    @endpush
    @if ($errors->any())
    <div class="alert alert-icon-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <div class="alert-icon icon-part-danger">
            <i class="fa fa-times"></i>
        </div>
        <div class="alert-message">
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
                </ul>
        </div>
    </div>
    @endif
    <div class="kt-portlet">
        <div class="kt-portlet__body kt-portlet__body--fit">
            <div class="kt-grid kt-grid--desktop-xl kt-grid--ver-desktop-xl  kt-wizard-v1"
                    id="kt_wizard_v1" data-ktwizard-state="step-first">

                <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v1__wrapper">
                    <!--begin: Form Wizard Form-->
                <form class="kt-form" id="kt_form" method="post" action="{{route('infos.update',[setting()->id])}}"   enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" id="id" value="{{ setting()->id }}">
                        <!--begin: Form Wizard Step 1-->
                        <div class="kt-wizard-v1__content" data-ktwizard-type="step-content"
                                data-ktwizard-state="current">
                            <div class="kt-form__section kt-form__section--first">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>{{__('app.settings.form.website_name_ar')}}</label>
                                            <input type="text" class="form-control" name="name_ar"
                                                    placeholder="{{__('app.settings.form.website_name_ar')}}" value="{{ old('name_ar', setting()->name_ar  ) }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>{{__('app.settings.form.website_name_en')}}</label>
                                            <input type="text" class="form-control" name="name_en"
                                                    placeholder="{{__('app.settings.form.website_name_en')}}" value="{{ old('name', setting()->name_en  ) }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>{{__('app.settings.form.phone')}}</label>
                                            <input type="text" class="form-control" name="phone"
                                                    placeholder="{{__('app.settings.form.phone_desc')}}" value="{{ old('phone', setting()->phone  ) }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>{{__('app.settings.form.email')}}</label>
                                            <input type="email" class="form-control" name="email"
                                                    placeholder="{{__('app.settings.form.email_holder')}}" value="{{ old('email', setting()->email  ) }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>{{__('app.settings.form.phone_message')}}</label>
                                            <input type="text" class="form-control" name="phone_message"
                                                    placeholder="{{__('app.settings.form.phone_message_desc')}}" value="{{ old('phone_message', setting()->phone_message  ) }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>{{__('app.settings.form.email_message')}}</label>
                                            <input type="email_message" class="form-control" name="email_message"
                                            placeholder="{{__('app.settings.form.email_message_holder')}}" value="{{ old('email_message', setting()->email_message  ) }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>{{__('app.settings.form.fb_link')}}</label>
                                            <input type="text" class="form-control" name="fb_link"
                                                    placeholder="{{__('app.settings.form.fb_link_desc')}}" value="{{ old('fb_link', setting()->fb_link  ) }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>{{__('app.settings.form.tw_link')}}</label>
                                            <input type="text" class="form-control" name="tw_link"
                                                    placeholder="{{__('app.settings.form.tw_link_desc')}}" value="{{ old('tw_link', setting()->tw_link  ) }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>{{__('app.settings.form.in_link')}}</label>
                                            <input type="text" class="form-control" name="in_link"
                                                    placeholder="{{__('app.settings.form.in_link_desc')}}" value="{{ old('in_link', setting()->in_link  ) }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>{{__('app.settings.form.insta_link')}}</label>
                                            <input type="text" class="form-control" name="insta_link"
                                                    placeholder="{{__('app.settings.form.insta_link_desc')}}" value="{{ old('insta_link', setting()->insta_link  ) }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>{{__('app.settings.form.website_link')}}</label>
                                            <input type="text" class="form-control" name="website_link"
                                                    placeholder="{{__('app.settings.form.website_link_desc')}}" value="{{ old('website_link', setting()->website_link  ) }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>{{__('app.settings.form.address')}}</label>
                                            <input type="text" class="form-control" name="address"
                                                    placeholder="{{__('app.settings.form.address_desc')}}" value="{{ old('address', setting()->address  ) }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>{{__('app.settings.form.app_version')}}</label>
                                            <input type="text" class="form-control" name="app_version"
                                                    value="{{ old('app_version', setting()->app_version  ) }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>{{__('app.settings.form.appStore_link')}}</label>
                                            <input type="text" class="form-control" name="appStore_link"
                                                    placeholder="{{__('app.settings.form.appStore_link_desc')}}" value="{{ old('appStore_link', setting()->appStore_link  ) }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>{{__('app.settings.form.googlePlay_link')}}</label>
                                            <input type="text" class="form-control" name="googlePlay_link"
                                                    placeholder="{{__('app.settings.form.googlePlay_link_desc')}}" value="{{ old('googlePlay_link', setting()->googlePlay_link  ) }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>{{__('app.settings.form.main_color')}}</label>
                                            <input type="color" class="form-control" name="main_color"
                                                    placeholder="{{__('app.settings.form.main_color_desc')}}" value="{{ old('main_color', setting()->main_color  ) }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>{{__('app.settings.form.secondary_color')}}</label>
                                            <input type="color" class="form-control" name="secondary_color"
                                                    placeholder="{{__('app.settings.form.secondary_color_desc')}}" value="{{ old('secondary_color', setting()->secondary_color  ) }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>{{__('app.settings.form.main_font_color')}}</label>
                                            <input type="color" class="form-control" name="main_font_color"
                                                    placeholder="{{__('app.settings.form.main_font_color_desc')}}" value="{{ old('main_font_color', setting()->main_font_color  ) }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>{{__('app.settings.form.secondary_font_color')}}</label>
                                            <input type="color" class="form-control" name="secondary_font_color"
                                                    placeholder="{{__('app.settings.form.secondary_font_color_desc')}}" value="{{ old('secondary_font_color', setting()->secondary_font_color  ) }}">
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>{{__('app.settings.form.bio_ar')}}</label>
                                            <textarea type="text" class="form-control" name="bio_ar"
                                                    placeholder="{{__('app.settings.form.bio_desc')}}">{{ old('bio_ar', setting()->bio_ar  ) }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>{{__('app.settings.form.bio_en')}}</label>
                                            <textarea type="text" class="form-control" name="bio_en"
                                                      placeholder="{{__('app.settings.form.bio_desc')}}">{{ old('bio_en', setting()->bio_en  ) }}</textarea>
                                        </div>
                                    </div>


                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>{{__('app.settings.form.privacy_ar')}}</label>
                                            <textarea type="text" class="form-control" name="privacy_ar"
                                                      placeholder="{{__('app.settings.form.bio_desc')}}">{{ old('privacy_ar', setting()->privacy_ar  ) }}</textarea>
                                        </div>
                                    </div>


                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>{{__('app.settings.form.privacy_en')}}</label>
                                            <textarea type="text" class="form-control" name="privacy_en"
                                                      placeholder="{{__('app.settings.form.bio_desc')}}">{{ old('privacy_en', setting()->privacy_en  ) }}</textarea>
                                        </div>
                                    </div>


                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>{{__('app.settings.form.agreement_ar')}}</label>
                                            <textarea type="text" class="form-control" name="agreement_ar"
                                                      placeholder="{{__('app.settings.form.bio_desc')}}">{{ old('agreement_ar', setting()->agreement_ar  ) }}</textarea>
                                        </div>
                                    </div>


                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>{{__('app.settings.form.agreement_en')}}</label>
                                            <textarea type="text" class="form-control" name="agreement_en"
                                                      placeholder="{{__('app.settings.form.bio_desc')}}">{{ old('agreement_en', setting()->agreement_en  ) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="kt-wizard-v1__content" data-ktwizard-type="step-content">
                            <div class="kt-heading kt-heading--md">{{__('app.settings.webSite_Media')}}</div>
                            <div class="kt-separator kt-separator--height-sm"></div>
                            <div class="kt-form__section kt-form__section--first">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group" style="text-align: center">
                                                <div class="kt-avatar" id="kt_profile_avatar_2">
                                                    <div class="kt-avatar__holder" style="margin-left: 35px;"></div>
                                                    <label class="kt-avatar__upload"  data-toggle="kt-tooltip" title="{{__('app.settings.change_logo')}}">
                                                        <i class="fa fa-pen"></i>
                                                        <input style="visibility: hidden" type='file' onchange="loadFile2(event,'output1')"  name="logo_en" />
                                                        <img id="output1" src="{{asset('storage/info/images/'.setting()->logo_en)}}" width="120px" height="120px">
                                                    </label>
                                                    <span class="form-text text-muted">{{__('app.settings.change_logo_desc_en')}}</span>
                                                    <span class="kt-avatar__cancel" data-toggle="kt-tooltip" title="Cancel avatar">
                                                        <i class="fa fa-times"></i>
                                                    </span>
                                                </div>
                                        </div>

                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group" style="text-align: center">
                                                <div class="kt-avatar" id="kt_profile_avatar_2">
                                                    <div class="kt-avatar__holder" style="margin-left: 35px;"></div>
                                                    <label class="kt-avatar__upload"  data-toggle="kt-tooltip" title="{{__('app.settings.change_logo')}}">
                                                        <i class="fa fa-pen"></i>
                                                        <input type='file' onchange="loadFile2(event,'output2')" style="visibility: hidden" name="logo_ar" />
                                                        <img id="output2" src="{{asset('storage/info/images/'.setting()->logo_ar)}}" width="120px" height="120px">
                                                    </label>
                                                    <span class="form-text text-muted">{{__('app.settings.change_logo_desc_ar')}}</span>
                                                    <span class="kt-avatar__cancel" data-toggle="kt-tooltip" title="Cancel avatar">
                                                        <i class="fa fa-times"></i>
                                                    </span>
                                                </div>
                                        </div>

                                    </div>
                                    <div class="col-lg-4">

                                        <div class="form-group" style="text-align: center">
                                                <div class="kt-avatar" id="kt_profile_avatar_1">
                                                    <div class="kt-avatar__holder" style="margin-left: 35px;)"></div>
                                                    <label class="kt-avatar__upload"  data-toggle="kt-tooltip" title="{{__('app.settings.change_icon')}}">
                                                        <i class="fa fa-pen"></i>
                                                        <input type='file'onchange="loadFile2(event,'output3')" style="visibility: hidden" name="icon"/>
                                                        <img id="output3"  src="{{asset('storage/info/images/'.setting()->icon)}}" width="120px" height="120px">
                                                    </label>
                                                    <span class="form-text text-muted">{{__('app.settings.change_icon_desc')}}</span>
                                                    <span class="kt-avatar__cancel" data-toggle="kt-tooltip" title="Cancel avatar">
                                                        <i class="fa fa-times"></i>
                                                    </span>
                                                </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-warning">{{__('app.settings.submit_page')}}</button>
                    </form>
                    <!--end: Form Wizard Form-->
                </div>
            </div>
        </div>
    </div>
@endsection
