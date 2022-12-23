@extends(backpack_view('blank'))

@section('header')

@endsection

@section('content')
    <div id="app">
        <modal v-if="showModal" @close="showModal = false" @answer="answer" :view="view" :status="status" :role="role"></modal>
        <answered v-if="showAnsweredModal" @close="showAnsweredModal = false" :answered_view="answered_view" :role="role"></answered>
        <div class="bg-white border rounded">
            <div class="border-bottom p-2">
                <div class="m-0 p-3 d-flex justify-content-center">
                    <div class="header-switcher d-flex">
                        <div class="header-switcher-item text-muted" :class="{'header-switcher-item-sel':(type)}" @click="type = true">В обработке</div>
                        @if(backpack_user()->{\App\Domain\Contracts\Contract::ROLE} !== 'lawyer')
                            <div class="header-switcher-item text-muted" :class="{'header-switcher-item-sel':(!type)}" @click="type = false">Закрытые</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="questions" v-if="type">
                <div class="question" v-for="(question,key) in questions" :key="key">
                    <div class="question-header">
                        <div class="question-header-icon" v-if="!question.is_important">?</div>
                        <div class="question-header-icon question-header-icon-fire" v-else></div>
                        <div class="question-header-content">
                            <div class="question-header-content-title font-weight-bold">#@{{ question.id }}</div>
                            <div class="question-header-content-description text-muted">@{{ question.created_at }}</div>
                        </div>
                        <div class="question-header-timer">15:29</div>
                    </div>
                    <div class="question-main flex-grow-1">
                        <div class="question-main-title">@{{ question.title }}</div>
                        <div class="question-main-detail" v-if="question.answered_at">@{{ question.answer }}</div>
                    </div>
                    <div class="question-body">
                        <div class="question-body-user" v-if="question.user">
                            <div class="question-body-user-icon">@{{ question.user.name[0] }}</div>
                            <div class="question-body-user-title">@{{ question.user.name }} @{{ question.user.surname }}</div>
                        </div>
                        <div class="question-body-user" v-if="question.lawyer">
                            <div class="question-body-user-icon question-body-user-icon-lawyer">@{{ question.lawyer.name[0] }}</div>
                            <div class="question-body-user-title question-body-user-title-lawyer">@{{ question.lawyer.name }} @{{ question.lawyer.surname }}</div>
                        </div>
                    </div>
                    <div class="question-button">
                        <div class="question-button-answer" v-if="role === 'lawyer' && !question.answered_at" @click="detail(question.id)">Ответить</div>
                        <div class="question-button-detail" v-else @click="detail(question.id)">Предпросмотр</div>
                    </div>
                </div>
            </div>
            <div class="questions" v-else>
                <div class="question" v-for="(question,key) in answeredQuestions" :key="key">
                    <div class="question-header">
                        <div class="question-header-icon" v-if="!question.is_important">?</div>
                        <div class="question-header-icon question-header-icon-fire" v-else></div>
                        <div class="question-header-content">
                            <div class="question-header-content-title font-weight-bold">#@{{ question.id }}</div>
                            <div class="question-header-content-description text-muted">@{{ question.created_at }}</div>
                        </div>
                        <div class="question-header-timer">15:29</div>
                    </div>
                    <div class="question-main flex-grow-1">
                        <div class="question-main-title">@{{ question.title }}</div>
                        <div class="question-main-detail" v-if="question.answered_at">@{{ question.answer }}</div>
                    </div>
                    <div class="question-body">
                        <div class="question-body-user" v-if="question.user">
                            <div class="question-body-user-icon">@{{ question.user.name[0] }}</div>
                            <div class="question-body-user-title">@{{ question.user.name }} @{{ question.user.surname }}</div>
                        </div>
                        <div class="question-body-user" v-if="question.lawyer">
                            <div class="question-body-user-icon question-body-user-icon-lawyer">@{{ question.lawyer.name[0] }}</div>
                            <div class="question-body-user-title question-body-user-title-lawyer">@{{ question.lawyer.name }} @{{ question.lawyer.surname }}</div>
                        </div>
                    </div>
                    <div class="question-button">
                        <div class="question-button-detail" @click="answerDetail(question.id)">Предпросмотр</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('after_scripts')
    <script type="text/x-template" id="modal-template">
        <transition name="modal">
            <div class="modal-mask">
                <div class="modal-wrapper">
                    <div class="modal-container" v-if="view">
                        <div class="modal-header-icon modal-header-icon-important" v-if="view.is_important"></div>
                        <div class="modal-header-icon" v-else>?</div>
                        <div class="modal-header d-flex align-items-center justify-content-center pt-5 border-0 h5 m-0 pb-0" style="gap: 10px;">Вопрос <span class="font-weight-bold">#@{{view.id}}</span></div>
                        <div class="modal-body">
                            <div class="modal-body-card border mb-3">
                                <div class="modal-body-item border-bottom">
                                    <div class="modal-body-item-key text-muted">Дата создания</div>
                                    <div class="modal-body-item-value">@{{ view.created_at }}</div>
                                </div>
                                <div class="modal-body-item border-bottom">
                                    <div class="modal-body-item-key text-muted">Пользователь</div>
                                    <div class="modal-body-item-value">@{{ view.user.name }} @{{ view.user.surname }}</div>
                                </div>
                                <div class="modal-body-item">
                                    <div class="modal-body-item-key text-muted">Цена</div>
                                    <div class="modal-body-item-value">@{{ view.price }}</div>
                                </div>
                                <div class="modal-body-item border-top" v-if="view.lawyer">
                                    <div class="modal-body-item-key text-muted">Юрист</div>
                                    <div class="modal-body-item-value">@{{ view.lawyer.name }} @{{ view.lawyer.surname }}</div>
                                </div>
                                <div class="modal-body-item border-top" v-if="view.answered_at">
                                    <div class="modal-body-item-key text-muted">Отвечено</div>
                                    <div class="modal-body-item-value">@{{ view.answered_At }}</div>
                                </div>
                            </div>
                            <div class="h6 font-weight-bold mb-2 text-center">Вопрос</div>
                            <div class="modal-body-title text-muted mb-2">@{{view.title.trim()}}</div>
                            <template v-if="role === 'lawyer'">
                                <template v-if="view.answered_at">
                                    <div class="h6 font-weight-bold mb-2 text-center">Ответ</div>
                                    <div class="modal-body-title">@{{view.answer.trim()}}</div>
                                </template>
                                <template v-else>
                                    <div class="h6 font-weight-bold mb-2 text-center">
                                        <label for="textarea">Ваш ответ</label>
                                    </div>
                                    <div class="modal-body-textarea">
                                        <textarea class="mt-2" id="textarea" rows="8" v-model="view.answer" @keydown.enter="$emit('answer')"></textarea>
                                    </div>
                                </template>
                            </template>
                            <template v-else>
                                <template v-if="view.answered_at">
                                    <div class="h6 font-weight-bold mb-2 text-center">Ответ</div>
                                    <div class="modal-body-title">@{{  view.answer.trim() }}</div>
                                </template>
                                <template v-else>
                                    <div class="p-3 text-center border bg-secondary text-dark rounded h6 m-0 mt-4 font-weight-bold">Ждет ответа</div>
                                </template>
                            </template>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button class="modal-default-button btn btn-danger h6" @click="$emit('close')">Закрыть</button>
                            <template v-if="role === 'lawyer' && !view.answered_at">
                                <button class="modal-default-button btn btn-success h6" @click="$emit('answer')" v-if="!status">Ответить</button>
                                <button class="modal-default-button btn btn-success h6" disabled v-else>
                                    <i class="fa fa-spinner fa-spin"></i> Сохранение ответа
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </script>
    <script type="text/x-template" id="answered">
        <transition name="modal">
            <div class="modal-mask">
                <div class="modal-wrapper">
                    <div class="modal-container" v-if="answered_view">
                        <div class="modal-header-icon modal-header-icon-important" v-if="answered_view.is_important"></div>
                        <div class="modal-header-icon" v-else>?</div>
                        <div class="modal-header d-flex align-items-center justify-content-center pt-5 border-0 h5 m-0 pb-0" style="gap: 10px;">Вопрос <span class="font-weight-bold">#@{{answered_view.id}}</span></div>
                        <div class="modal-body">
                            <div class="modal-body-card border mb-3">
                                <div class="modal-body-item border-bottom">
                                    <div class="modal-body-item-key text-muted">Дата создания</div>
                                    <div class="modal-body-item-value">@{{ answered_view.created_at }}</div>
                                </div>
                                <div class="modal-body-item border-bottom">
                                    <div class="modal-body-item-key text-muted">Пользователь</div>
                                    <div class="modal-body-item-value">@{{ answered_view.user.name }} @{{ answered_view.user.surname }}</div>
                                </div>
                                <div class="modal-body-item">
                                    <div class="modal-body-item-key text-muted">Цена</div>
                                    <div class="modal-body-item-value">@{{ answered_view.price }}</div>
                                </div>
                                <div class="modal-body-item border-top" v-if="answered_view.lawyer">
                                    <div class="modal-body-item-key text-muted">Юрист</div>
                                    <div class="modal-body-item-value">@{{ answered_view.lawyer.name }} @{{ answered_view.lawyer.surname }}</div>
                                </div>
                                <div class="modal-body-item border-top" v-if="answered_view.answered_at">
                                    <div class="modal-body-item-key text-muted">Отвечено</div>
                                    <div class="modal-body-item-value">@{{ answered_view.answered_At }}</div>
                                </div>
                            </div>
                            <div class="h6 font-weight-bold mb-2 text-center">Вопрос</div>
                            <div class="modal-body-title text-muted mb-2">@{{answered_view.title.trim()}}</div>
                            <template v-if="answered_view.answered_at">
                                <div class="h6 font-weight-bold mb-2 text-center">Ответ</div>
                                <div class="modal-body-title">@{{  answered_view.answer.trim() }}</div>
                            </template>
                            <template v-else>
                                <div class="p-3 text-center border bg-secondary text-dark rounded h6 m-0 mt-4 font-weight-bold">Ждет ответа</div>
                            </template>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                            <button class="modal-default-button btn btn-danger h6" @click="$emit('close')">Закрыть</button>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        Vue.component("modal", {
            props: ['view','status','role'],
            template: "#modal-template"
        });
        Vue.component("answered", {
            props: ['answered_view','role'],
            template: "#answered"
        });
        let app = new Vue({
            el: '#app',
            data: {
                type: true,

                showModal: false,
                questions: [],
                count: 0,
                view: false,
                status: false,
                id: 0,
                page: 1,

                showAnsweredModal: false,
                answeredQuestions: [],
                answeredCount: 0,
                answered_view: false,
                answered_id: 0,
                answered_page: 1,

                is_paid: true,
                take: 100,

                user_id:  {{ backpack_user()->{\App\Domain\Contracts\Contract::ID} }},
                role:  '{{ backpack_user()->{\App\Domain\Contracts\Contract::ROLE} }}',


            },
            created() {
                this.refresh();
            },
            methods: {
                refresh() {
                    this.getQuestions();
                    this.getAnsweredQuestions();
                },
                questionReplace(question) {
                    for (let key in this.questions) {
                        if (question.id === this.questions[key].id) {
                            this.questions.splice(key, 1, question);
                        }
                    }
                    if (this.view.id === question.id) {
                        this.detail(question.id);
                    }
                },
                answer() {
                    this.status =   true;
                    axios
                        .post('/api/v1/question/update/'+this.view.id, {
                            lawyer_id: this.user_id,
                            answer: this.view.answer,
                        })
                        .then(response => {
                            this.questionReplace(response.data.data);
                            this.refresh();
                        })
                        .catch(error => {
                            this.status =   false;
                            this.refresh();
                        });
                },
                getQuestions() {
                    axios
                        .post('/api/v1/question/get?page='+this.page+'&order_by_type=desc&take='+this.take,{
                            is_paid: this.is_paid,
                            status: 1,
                        })
                        .then(response => {
                            this.questions  =   response.data.data;
                            this.count  =   response.data.count;
                            this.hide();
                        });
                },
                hide() {
                    this.status =   false;
                    this.showModal = false;
                },
                detail(id) {
                    this.id =   id;
                    this.questions.forEach(question => {
                        if (question.id === this.id) {
                            this.view   =   question;
                        }
                    });
                    this.status =   false;
                    this.showModal = true;
                },

                getAnsweredQuestions() {
                    axios
                        .post('/api/v1/question/get?page='+this.answered_page+'&order_by=updated_at&order_by_type=desc&take='+this.take,{
                            is_paid: this.is_paid,
                            status: 2,
                            @if (backpack_user()->{\App\Domain\Contracts\Contract::ROLE} === 'lawyer')
                            lawyer_id: {{backpack_user()->{\App\Domain\Contracts\Contract::ID} }},
                            @endif
                        })
                        .then(response => {
                            this.answeredQuestions  =   response.data.data;
                            this.answeredCount  =   response.data.count;
                            this.showAnsweredModal   =   false;
                        });
                },
                answerDetail(id) {
                    this.answered_id    =   id;
                    this.answeredQuestions.forEach(question => {
                        if (question.id === this.answered_id) {
                            this.answered_view  =   question;
                        }
                    });
                    this.showAnsweredModal   =   true;
                }
            },
        })
    </script>
@endsection
@section('after_styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .header-switcher-item {
            padding: 8px 10px 8px 10px;
            cursor: pointer;
            font-size: 14px;
            border-radius: 30px;
        }
        .header-switcher-item-sel, .header-switcher-item:hover {
            background: white;
            box-shadow: 0 0 5px 1px rgba(0,0,0,.2);
        }
        .header-switcher {
            background: #f0f0f0;
            padding: 5px;
            gap: 5px;
            border-radius: 50px;
        }
        .question-body-user-icon {
            width: 20px;
            height: 20px;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #a3e8cd;
            color: darkgreen;
            border-radius: 30px;
            text-transform: capitalize;
        }
        .question-body-user-icon-lawyer {
            background: #0091c1;
            color: white;
        }
        .question-body-user-title {
            color: darkgreen;
        }
        .question-body-user-title-lawyer {
            color: #0091c1;
        }
        .question-body-user {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .question-body {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .question-button-answer, .question-button-detail {
            text-align: center;
            font-size: 14px;
            cursor: pointer;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
            font-weight: bold;
            padding: 0 10px 0 10px;
        }
        .question-button-answer {
            background: #a3e8cd;
            color: darkgreen;
        }
        .question-button-detail {
            background: #0091c1;
            color: white;
        }
        .question-button {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .question-header-content-description {
            font-size: 14px;
        }
        .question-header-content-title {
            font-size: 18px;
        }
        .question-header-icon {
            width: 50px;
            height: 50px;
            background: #a3e8cd;
            border-radius: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            font-weight: bold;
            color: darkgreen;
            position: relative;
        }
        .question-header-icon-fire {
            background-image: url('/img/1.png');
            background-repeat: no-repeat;
            background-position: center;
        }
        .question-header-timer {
            background: #a3e8cd;
            color: darkgreen;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            padding: 2px 8px 2px 8px;
        }
        .question-header {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .question-main-detail {
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
        }
        .question-main-title {
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
            color: #0091c1;
        }
        .question-main {
            width: 400px;
            display: flex;
            justify-content: center;
            flex-direction: column;
        }
        .question {
            display: flex;
            padding: 20px;
            gap: 20px;
            border: 1px solid #f5f5f5;
            border-radius: 5px;
            background: #fafafa;
            cursor: pointer;
        }
        @media (max-width: 1300px) {
            .question {
                padding: 10px;
                flex-direction: column;
                gap: 10px;
                background: #f0f0f0;
            }
            .question-main {
                width: 100%;
            }
            .question-header-timer {
                margin-left: auto;
            }
            .question-button {
                padding-top: 10px;
                border-top: 1px solid rgba(0,40,100,.12)!important;
            }
            .question-button-answer, .question-button-detail {
                width: 100%;
            }
        }
        .question:hover {
            background: #f0f0f0;
        }
        .questions {
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding: 10px;
        }
        .modal-mask {
            position: fixed;
            z-index: 9998;
            top: 0;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            transition: opacity 0.3s ease;
            overflow: auto;
            padding: 200px 0 200px 0;
        }

        .modal-wrapper {
            display: block;
        }

        .modal-container {
            width: 500px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
            transition: all 0.3s ease;
            font-family: Helvetica, Arial, sans-serif;
            position: relative;
        }
        .modal-header-icon {
            width: 80px;
            height: 80px;
            position: absolute;
            top: -40px;
            left: 50%;
            transform: translate(-50%,0);
            background: #a3e8cd;
            border-radius: 100px;
            border: 10px solid #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            font-weight: bold;
            color: darkgreen;
        }
        .modal-header-icon-important {
            background-image: url(/img/1.png);
            background-repeat: no-repeat;
            background-position: center;
        }
        .modal-header h3 {
            margin-top: 0;
            color: #42b983;
        }
        .modal-body-item-value {
            width: 70%;
            font-weight: bold;
            color: #0091c1;
        }
        .modal-body-item-key {
            text-align: right;
            width: 30%;
        }
        .modal-body-item > div {
            padding: 10px;
            font-size: 14px;
        }
        .modal-body-item {
            display: flex;
        }
        .modal-body-card {
            border-radius: 5px;
            background: #fafafa;
        }
        .modal-body {
            margin: 0 20px 20px 20px;
        }
        .modal-body-title {
            font-size: 14px;
            text-align: justify;
            text-indent: 20px;
            white-space: pre-wrap;
        }
        .modal-body-textarea {
            font-size: 14px;
        }
        .modal-body-textarea > textarea {
            width: 100%;
            resize: none;
            height: 100%;
            border: 1px solid rgba(0,40,100,.12)!important;
            border-radius: 5px;
            outline: none;
            background: #fafafa;
            padding: 15px;
            overflow: hidden;
        }
        .modal-default-button {
            float: right;
        }

        /*
         * The following styles are auto-applied to elements with
         * transition="modal" when their visibility is toggled
         * by Vue.js.
         *
         * You can easily play with the modal transition by editing
         * these styles.
         */

        .modal-enter {
            opacity: 0;
        }

        .modal-leave-active {
            opacity: 0;
        }

        .modal-enter .modal-container,
        .modal-leave-active .modal-container {
            -webkit-transform: scale(1.1);
            transform: scale(1.1);
        }
    </style>
@endsection
