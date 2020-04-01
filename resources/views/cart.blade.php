@extends('layout.index')
@section('title', 'ページタイトル')
@section('description', 'description')
@section('body')
<style>
    .btn-disabled {
        pointer-events: none;
    }
</style>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script>
    $(function() {
        $('.del_btn').on('click', function(event) {
            event.preventDefault();
            $('.del_btn').addClass('btn-disabled');
            $('.purchase_btn').addClass('btn-disabled');
            $('select[name=quantity]').attr('disabled', true);
            $.ajax({
                url: "{{ route('cart_remove') }}",
                type: 'post',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': $(this).data('id')
                },
                timeout: 10000,
                success: function(result, textStatus, xhr) {
                    window.location.href = "{{ route('cart') }}";
                },
                error: function(data) {
                    $('.del_btn').attr('disabled', false);
                    alert('エラーが発生しました。');
                    window.location.href = "{{ route('cart') }}";
                }
            });
        });
        $('select[name=quantity]').on('change', function(event) {
            event.preventDefault();
            $('.del_btn').addClass('btn-disabled');
            $('.purchase_btn').addClass('btn-disabled');
            $('select[name=quantity]').attr('disabled', true);
            $.ajax({
                url: "{{ route('cart_quantity') }}",
                type: 'post',
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': $(this).data('id'),
                    'quantity': $(this).val(),
                },
                timeout: 10000,
                success: function(result, textStatus, xhr) {
                    window.location.href = "{{ route('cart') }}";
                },
                error: function(data) {
                    $('.del_btn').attr('disabled', false);
                    alert('エラーが発生しました。');
                    window.location.href = "{{ route('cart') }}";
                }
            });
        });
    });
</script>
<article>
    <h2>カート</h2>
    @if (@$mes == 1)
    <div class="attention noimage">
        <p>すでにカートに入っています。</p>
    </div>
    @endif
    @if (empty(@$cart['items']))
    <div class="thint noimage">
        <p>現在カートはからです。</p>
    </div>
    @else
    <table class="table">
        <tbody>
            @foreach(@$cart['items'] as $k => $v)
            <tr>
                <td><img src="/img/dummy.jpg" alt="dummy" width="100"></td>
                <td><a href="{{ route('product', ['id' => $v['id']]) }}">{{$v['title']}}</a></td>
                <td>{{number_format($v['price'])}}円</td>
                <td>
                    <select name="quantity" data-id="{{$v['id']}}">
                        @foreach (Config::get('const.quantity') as $k2 => $v2)
                        <option value="{{$k2}}" @if (@$v['quantity']==$k2) selected @endif>{{$v2}}</option>
                        @endforeach
                    </select>個
                </td>
                <td><a href="" class="del_btn" data-id="{{$v['id']}}">削除</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
    @if (!empty(@$cart['items']))
    <hr>
    合計{{number_format(@$cart['price'])}}円
    <hr>
    <a href="{{ route('purchase') }}" class="purchase_btn">購入する</a>
    @endif
</article>
@endsection