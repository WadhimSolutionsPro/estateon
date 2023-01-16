@extends('layouts.estate')
@section('content')
@if(isset($data['property']['images']) && count($data['property']['images'])> 0)
<div class="s_outer">
    <div class="propty_silde">
    @foreach($data['property']['images'] as $image)
        <div class="full_img">
            <a>
                <div class="image-wraper"><img src="{{$image->url}}" /></div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endif
<section class="pprty_detail space">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="property-information d-md-flex align-items-center">
                    <div class="left-infor">
                        <div class="title-wrapper">
                            <h2 class="property-title">{{$data['property']->name ?? ''}}</h2>
                            @if($data['property']->featured==1)
                            <span class="featured-property">Featured</span>
                            @endif
                            @if($data['property']->hot==1)
                            <span class="featured-property">Hot</span>
                            @endif
                          
                        </div>
                        <div class="property-location">
                            <a>{{$data['property']->address}}</a>
                        </div>
                    </div>
                    <div class="property-action-detail ali-right">
                        <div class="property-price">
                            <span class="suffix">&#8377;</span>
                            <span class="price-text">{{$data['property']['property_details']->price}}</span>
                        </div>
                        <button class="btn-add-property-favorite fvrt-btn" data-original-title="Add Favorite">
                            <i class="far fa-heart"></i></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="wht_box">
                            <h3>Overview</h3>
                            <p class="mb-3">
                               {{$data['property']->description}}
                            </p>
                            <p class="mb-3">
                            {{$data['property']->notes}}
                            </p>
                            </div>

                        <div class="wht_box mt-4">
                            <h3>Details</h3>
                            <div class="property-list">
                                <ul class="list">
                                    <li>
                                        <div class="text">Property ID:</div>
                                        <div class="value">PR{{$data['property']['property_details']->property_id}}</div>
                                    </li>
                                    @if($data['property']['property_details']->size > 1)
                                    <li>
                                        <div class="text">Lot Area:</div>
                                        <div class="value">{{$data['property']['property_details']->size}}</div>
                                    </li>
                                    @endif
                                    @if($data['property']['property_details']->size > 1)
                                    <li>
                                        <div class="text">Lot dimensions:</div>
                                        <div class="value">{{$data['property']['property_details']->length}}x{{$data['property']['property_details']->width}}</div>
                                    </li>
                                    @endif
                                    @if($data['property']['property_details']->bedroom > 0)
                                    <li>
                                        <div class="text">Beds:</div>
                                        <div class="value">{{$data['property']['property_details']->bedroom}}</div>
                                    </li>
                                    @endif
                                    @if($data['property']['property_details']->bathroom > 0)
                                    <li>
                                        <div class="text">Baths:</div>
                                        <div class="value">{{$data['property']['property_details']->bathroom}}</div>
                                    </li>
                                    @endif
                                    @if($data['property']['property_details']->price > 0)
                                    <li>
                                        <div class="text">Price:</div>
                                        <div class="value"><span class="suffix">₹</span> <span class="price-text">{{$data['property']['property_details']->price}}</span></div>
                                    </li>
                                    @endif
                                    <li>
                                        <div class="text">Property Status:</div>
                                        <div class="value"><a class="status-property-label">{{$data['property']['type']=='sale'? 'For Sale':'For Rent'}}</a></div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @if(isset($data['property']['amenities']) && count($data['property']['amenities'])> 0)
                        <div class="wht_box mt-4">
                            <h3>Amenities</h3>
                            <div class="property-amenities">
                                <ul class="columns-gap list-check">
                                    @foreach($data['property']['amenities'] as $amenity)
                                    <li class="yes">{{$amenity->amenity_data->name ?? ''}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endif
                        @if($data['property']->lat != "" && $data['property']->lng != "")
                        <div class="wht_box mt-4">
                            <div class="in_box title">
                                <h3>locations</h3>
                                <p><span class="location-icon"><img src="{{url('estate/images/location_blk.png')}}" alt="location-icon" /></span>{{$data['property']->address}}</p>
                            </div>
                            <div class="proprty-map-area">
                                <iframe src="https://maps.google.com/maps?q={{$data['property']->lat}},{{$data['property']->lng}}&hl=es&z=14&amp;output=embed" width="100%" height="315" allowfullscreen="" loading="lazy"></iframe>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="col-md-4">
                        <div class="wht_box">
                            <div class="contact_for_prp">
                                <h3>Contact Agent</h3>
                                <form id="contact-agent">
                                    <div class="form-group">
                                        <input type="name" name="name" id="name" class="form-control" placeholder="Name" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="email" id="email" class="form-control" placeholder="Email Address" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="phone" name="phone" id="phone" class="form-control" placeholder="Phone Number" required>
                                    </div>
                                    <div class="form-group mb-4">
                                        <textarea class="form-control" rows="4" id="message" placeholder="Message" name="message" required></textarea>
                                    </div>
                                    <input type="hidden" name="property_id" value="{{$data['property']->id}}"> 
                                    <button class="cm-btn w-100" id="contact-agent-button">send message</button>
                                    <p class="message hide" style="margin-top: 10px"></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection
@section('scripts')
<script>


    var site_url = "{{url('/')}}";


$('body').on('click', '#contact-agent-button', function () {		
        var that = $(this);
        var data = that.closest('form#contact-agent').serialize();
        
        var isValid = true; 
        that.closest('form#contact-agent').find('input,textarea').each(function(){
            console.log($(this));
            if($(this).val() == "" || $(this).val() == null){
                isValid = false; 
                $(this).addClass('field-error')
            }else{
                $(this).removeClass('field-error')
            }

        });
        //return false;

        that.closest('form').find('.message').removeClass('text-success').removeClass('text-danger').addClass('hide').html('')
        if(isValid == false){
            that.closest('form').find('.message').removeClass('hide').addClass('text-danger').html('Please enter all fields')
            return false;
        }
        //console.log(data)        

        $.ajax({
            type: "POST",            
            dataType: "json",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: site_url + "/lead-add",
            data: {data: data},
            success: function (response) {
                if(response.success){
                    that.closest('form').find('.message').removeClass('hide').addClass('text-success').html('Someone from the concerned team will contact you soon!')
                    that.closest('form#contact-agent').find('input,textarea').val('');
                }else{                    
                    that.closest('form').find('.message').removeClass('hide').addClass('text-danger').html('Something went wrong!')
                }                
            }
        });
        return false;
    })

  $(document).ready(function() {
jQuery(".propty_silde").slick({
  infinite: true,
  autoplay: true,
  dots: false,
  autoplaySpeed: 3000,
  slidesToShow: 1,
  slidesToScroll: 1,
  speed: 500,
  arrows: true,
  prevArrow:
    "<button type='button' class='slick-prev slide-btn'><i class='fas fa-chevron-left' aria-hidden='true'></i></button>",
  nextArrow:
    "<button type='button' class='slick-next slide-btn'><i class='fas fa-chevron-right' aria-hidden='true'></i></button>",
});
  })
</script>
@endsection