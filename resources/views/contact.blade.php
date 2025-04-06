@extends('layouts.main')

@section('content')
    <section class="contact py-4">
        <div class="container">
            <x-breadcrumb-wrapper :breadcrumbs="[
                ['label' => 'Trang chủ', 'url' => route('home')],
                ['label' => 'Liên hệ', 'url' => route('contact')],
            ]" />
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d59604.89116279917!2d105.71162574863278!3d20.980379700000025!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ad2a2ee98b2f%3A0x58f577d5cca9d3f6!2zSOG7jWMgdmnhu4duIEPDtG5nIG5naOG7hyBCxrB1IGNow61uaCBWaeG7hW4gdGjDtG5nIC0gUFRJVA!5e0!3m2!1svi!2s!4v1743689108504!5m2!1svi!2s"
                width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>

            <div class="row">
                <div class="col-4">
                    <div class="item-contact">
                        <div class="img"> <i class="fas fa-map-marker-alt"></i> </div>
                        <div class="content-r"> Địa chỉ: <p> Tòa nhà Ladeco 266 Đội Cấn, Ba Đình, Hà Nội </p>
                        </div>
                    </div>
                    <div class="item-contact">
                        <div class="img"> <i class="fas fa-question"></i> </div>
                        <div class="content-r"> Gửi thắc mắc: <a href="mailto:support@sapo.vn">support@sapo.vn</a> </div>
                    </div>
                    <div class="item-contact">
                        <div class="img"> <i class="fas fa-phone-alt"></i> </div>
                        <div class="content-r"> Điện thoại: <a class="fone" href="tel:18006750">18006750</a> </div>
                    </div>
                </div>
                <div class="col-lg-8 col-12">
                    <div id="pagelogin">
                        <form action="/contact" id="contact" target="dnone_iframe">
                            <div class="alert alert-success d-none">
                                <p>Bạn đã gửi tin nhắn thành công</p>
                            </div>
                            <div class="form-signup clearfix">
                                <div class="row group_contact">
                                    <fieldset class="form-group col-lg-6 col-12"> <label>Họ và tên <em>*</em></label> <input
                                            placeholder="" type="text" class="form-control  form-control-lg"
                                            required="" value="" name="entry.xxxxxxx"> </fieldset>
                                    <fieldset class="form-group col-lg-6 col-12"> <label>Email <em>*</em></label> <input
                                            placeholder="" type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
                                            required="" id="email1" class="form-control form-control-lg"
                                            value="" name="entry.xxxxxxx"> </fieldset>
                                    <fieldset class="form-group col-12"> <label>Nội dung <em>*</em></label>
                                        <textarea placeholder="" name="entry.xxxxxxx" id="comment" class="form-control content-area form-control-lg"
                                            rows="5" required=""></textarea>
                                    </fieldset>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> <button type="submit"
                                            class="button-default">Gửi liên hệ</button> </div>
                                </div>
                            </div>
                        </form> <iframe class="hidden d-none" id="dnone_iframe" name="dnone_iframe"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
