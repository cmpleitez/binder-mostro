@extends('forestLayout')
@section('content')
 <form method="POST" action="{{Route('offer.update', ['offer'=>$offer])}}" enctype="multipart/form-data">
    @csrf @method('PATCH')
    <div class="card-deck mb-3 m-0">

        <!--IMAGE -->
        <div class="card col-lg-2 col-md-4 col-sm-12 d-flex align-items-center justify-content-center m-0 rounded-0 p-2">
            @if ( Storage::url($offer->pic) !== '/storage/' )
                <img class="card-img-top img-fluid" src="{{Storage::url($offer->pic)}}" alt="Imagen del servicio" />
            @else
                <img class="card-img-top img-fluid" src="{{asset('/img/producto.png')}}" alt="Imagen del servicio" />
            @endif
        </div>

        <div class="card col-lg-10 col-md-8 col-sm-12 m-0 rounded-0">
            <div class="card-body">
                <h4 class="card-title">
                    @lang('Offer edit')
                </h4>

                <!--PICTURE-->
               <div class="form-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="inputGroupFile01" name="pic">
                        <label class="custom-file-label" for="inputGroupFile01">@lang("Choose file")</label>
                        <span class="badge badge-light-danger">{{ $errors->first('pic') }}</span>
                    </div>
                </div>

                <!--CHARGE-->
                <div class="form-group">
                   <label class="text-bold-600" for="charge">@lang('Charge')</label>
                    <input type="text" class="form-control" id="charge" placeholder="$ USD 0.00" name="charge" value="{{ old('charge', $offer->charge) }}">
                    <span class="badge badge-light-danger">{{ $errors->first('charge') }}</span>
                </div>
            </div>

            <!--TABLERO DE CONTROL-->
            <div class="card-footer d-flex justify-content-end">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">@lang('Update')</i></button>
                </div>
            </div>

        </div>
    </div>
</form>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        var numberMask = IMask(charge, { //CHARGE
            mask: Number,
            scale: 2,
            thousandsSeparator: ',',
            padFractionalZeros: false,
            normalizeZeros: true,
            radix: '.',
            mapToRadix: ['.'],
            min: -999999,
            max: 999999
        });
    });
</script>

@endsection