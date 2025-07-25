@extends('layouts.app')

@section('conteudo')
    <main class="h-screen flex flex-col overflow-y-auto px-4">
        <div class="mt-16 mb-2 flex-1 w-full px-6 bg-white rounded-lg shadow-lg p-6">
            <form class="space-y-1" action="{{ route('unidades.unidades_store') }}" method="POST">
                @csrf
                @include('bairros.cadastrar_form')
            </form>
        </div>
    </main>



<script>
$(document).ready(function(){

 $('#country_name').keyup(function(){
        var query = $(this).val();
        if(query != '')
        {
         var _token = $('input[name="_token"]').val();
         $.ajax({
          url:"{{ route('bairros.fetch') }}",
          method:"POST",
          data:{query:query, _token:_token},
          success:function(data){
           $('#countryList').fadeIn();
                    $('#countryList').html(data);
          }
         });
        }
    });

    $(document).on('click', 'li', function(){
        $('#country_name').val($(this).text());
        $('#countryList').fadeOut();
    });

});
</script>

@endsection

@section('scripts')
@endsection



