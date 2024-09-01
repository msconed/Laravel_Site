<div id="modal" _="on closeModal add .closing then wait for animationend then remove me">
@csrf
    <div class="modal-underlay" _="on click trigger closeModal"></div>
    <div class="modal-content-auth">
        <div class="form">
            <p id="heading">Новый топик в {{$categoryName}} -> {{$SubCategoryName}}</p>
            <div class="field">
                <input name="header" autocomplete="off" placeholder="Заголовок" class="input-field" type="text">
            </div>

                <textarea name='text' placeholder="Сообщение..." class="input-field field nwt" type="text"></textarea>


            <div class="btn">
                <button _="on click toggle .disabled for 2s"
                    hx-include="[name='header'], [name='text'], [name='_token']" 
                    hx-post="{{ url('/forum/new_topic_create') }}" 
                    hx-swap="innerHTML"
                    hx-vals='{"path2": {{$path2}}}'
                    hx-target="#new-topic-errors"
                    
                    class="button2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Отправить&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</button>
            </div>
            <div style="color:red;" id="new-topic-errors"></div>
        </div>
    </div>
</div>