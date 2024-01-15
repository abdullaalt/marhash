@verbatim
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="cache-control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="pragma" content="no-cache" />
<meta http-equiv="expires" content="0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@600&family=Open+Sans:wght@300;400;500;600;700;800&family=PT+Sans+Caption:wght@400;700&display=swap" rel="stylesheet"> 
    <script
        src="https://code.jquery.com/jquery-2.2.4.min.js"
        integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
        crossorigin="anonymous"></script>
    <script src="https://api-maps.yandex.ru/2.1/?apikey=29db68d0-e934-43ad-ac73-515b8afcd5e6&lang=ru_RU&suggest_apikey=1ec51049-1ff3-4398-a07f-8693d5fb8fa9" type="text/javascript"></script>
    <link href="/css/styles.css?<?php echo time(); ?>" rel="stylesheet" />
    <script src="/js/jtmpl.js"></script>
    <script src="/js/jquery.cookies.js"></script>
    <script src="/js/xhr.js"></script>
    <script src="/js/map.js?dd5f488"></script>
    <script src="/js/content.js?dd5f488"></script>
    <script src="/js/auth.js?dd5f488"></script>
    <script src="/js/popups.js?dd5f488"></script>
    <script src="/js/script.js?dd5f488"></script>

    <title>Мархаш</title>
</head>
<body>
    
    <main>
        <header>
            <a class="logo" href="/">Мархаш</a>
            <div class="filter-panel">
                <div class="field">
                    <select class="sources" onchange="content.changeSource($(this))">
                        <option value="my">Мои точки</option>
                    </select>
                </div>

                <div class="field">
                    <select class="persons" onchange="content.changePerson($(this))">
                        
                    </select>
                </div>
            </div>
        </header>

        <div class="map">
            <div id="main-map">

            </div>
        </div>

        <div class="footer">
            <div class="menu-button-container">
                <a class="menu-button teams" onclick="content.showTeams()"></a>
                <a class="add" onclick="popups.showAddTeam()">+</a>
            </div>

            <div class="menu-button-container">
                <a class="menu-button points" onclick="content.showPoints()"></a>
                <a class="add" onclick="content.addPoint()">+</a>
            </div>

            <div class="menu-button-container">
                <a class="menu-button profile" onclick="popups.showAuth()"></a>
            </div>
        </div>
    </main>

    <div class="loader"></div>

    <div class="slideUp-container add-team">
        <div class="slideUp-container-content">
            <div class="add-team">
                <form id="add-team">
                    <div class="field">
                        <label>
                            <span>Введите описание команды</span>
                            <div class="input-field">
                                <input name="description" placeholder="Введите описание команды" type="text" class="text-input" />
                            </div>
                        </label>
                    </div>

                    <div class="field">
                        <div class="input-field">
                            <input value="Сохранить" type="button" class="button" onclick="content.saveTeam()"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="slideUp-container add-person-team">
        <div class="slideUp-container-content">
            <div class="add-person-team">
                <form id="add-person-team">
                    <div class="field">
                        <label>
                            <span>Введите ID пользователя</span>
                            <div class="input-field">
                                <input name="user_id" placeholder="Введите ID пользователя" type="text" class="text-input" />
                            </div>
                        </label>
                    </div>

                    <div class="field">
                        <div class="input-field">
                            <input value="Отправить приглашение" type="button" class="button" onclick="content.sendInv()"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="slideUp-container profile-info">
        <div class="slideUp-container-content">
            <div class="user-profile">
                
            </div>
        </div>
    </div>

    <div class="slideUp-container auth">
        <div class="slideUp-container-content">
            <div class="add-team">
                <form id="auth-form">
                    <div class="field">
                        <label>
                            <div class="input-field">
                                <input name="email" placeholder="Введите email" type="text" class="text-input" />
                            </div>
                        </label>
                    </div>

                    <div class="field">
                        <label>
                            <div class="input-field">
                                <input name="password" placeholder="Введите пароль" type="password" class="text-input" />
                            </div>
                        </label>
                    </div>

                    <div class="field">
                        <div class="input-field">
                            <input value="Отправить" type="button" class="button" onclick="auth.authorize(event)"/>
                            <input value="Создать аккаунт" type="button" class="mini-btn button" onclick="auth.regForm(event)"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="slideUp-container reg">
        <div class="slideUp-container-content">
            <div class="add-team">
                <form id="reg-form">
                <div class="field">
                        <label>
                            <div class="input-field">
                                <input name="username" placeholder="Введите имя пользователя" type="text" class="text-input" />
                            </div>
                        </label>
                    </div>

                    <div class="field">
                        <label>
                            <div class="input-field">
                                <input name="email" placeholder="Введите email" type="text" class="text-input" />
                            </div>
                        </label>
                    </div>

                    <div class="field">
                        <label>
                            <div class="input-field">
                                <input name="password" placeholder="Введите пароль" type="password" class="text-input" />
                            </div>
                        </label>
                    </div>

                    <div class="field">
                        <label>
                            <div class="input-field">
                                <input name="password_confirmation" placeholder="Повторите пароль" type="password" class="text-input" />
                            </div>
                        </label>
                    </div>

                    <div class="field">
                        <div class="input-field">
                            <input value="Зарегистрироваться" type="button" class="mini-btn button" onclick="auth.register(event)"/>
                            <input value="Войти в аккаунт" type="button" class="button" onclick="popups.showAuth(event)"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="slideUp-container add-point">
        <div class="slideUp-container-content">
            <div class="add-point-container">
                <form id="point-form">
                    <div class="field">
                        <label>
                            <div class="input-field">
                                <input name="who" placeholder="К кому идем" type="text" class="text-input" />
                            </div>
                        </label>
                        <span class="hint">Укажите коротко кем приходятся жильцы дома</span>
                    </div>

                    <div class="field">
                        <label>
                            <div class="input-field">
                                <select name="action">
                                    <option value="">Выберите действие</option>
                                    <option value="CELEBRATE">Поздравить и не заходить</option>
                                    <option value="GIVEMEMINUTE">Зайду и быстро выйду</option>
                                    <option value="TEA">Попьем чай</option>
                                    <option value="EAT">Поедим</option>
                                    <option value="FULL">И чай и еда</option>
                                    <option value="IDONTKNOW">По ситуации</option>
                                </select>
                            </div>
                        </label>
                    </div>

                    <div class="field">
                        <label>
                            <span>Введите адрес или сразу выберите точку на карте</span>
                        </label>
                        <span class="hint"></span>

                        <div id="addmap"></div>
                    </div>

                    <div class="field">
                        <div class="input-field">
                            <input value="Отправить" type="button" class="button" onclick="content.savePoint(event)"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="slideUp-container teams">
        <div class="slideUp-container-content">
            
        </div>
    </div>

    <div class="slideUp-container points">
        <div class="slideUp-container-content">
            
        </div>
    </div>

    <script id="team-points" type="text/x-jquery-tmpl">
        <div class="team-points-container">
        <a class="back" onclick="popups.slideDown($(this))">Назад</a>
            <a class="button mini-btn" onclick="content.showTeamPointsOnMap(${team_id})">Вывести на карте</a>
            <div class="team-points-list">
                {{each(index, item) items}}
                    <div class="points-item">
                        <div class="point-info">
                            <div class="who">${item.who}</div>
                            <div class="address">${item.address}</div>
                        </div>
                        <div class="action">
                            ${item.action}<br>
                            <span><b>Автор: </b>${item.user.username}</span>
                        </div>
                    </div>
                {{/each}}
            </div>
        </div>
    </script>

    <script id="points" type="text/x-jquery-tmpl">
        <div>
            <div class="points-list">
                {{each(index, item) items}}
                    <div class="points-item">
                        <div class="point-info">
                            <div class="who">${item.who}</div>
                            <div class="address">${item.address}</div>
                        </div>
                        <div class="action">${item.action}</div>
                        <div class="team-actions">
                            {{if item.bind}}
                                <div>
                                    Привязан к команде <span>${item.bind.description}</span>
                                    <a onclick="content.unlinkFromTeam(${item.bind.id}, ${item.id})">Отвязать</a>
                                </div>
                            {{else}}
                                <a onclick="content.linkWithTeam(${item.id}, $(this))">Привязать к команде</a>
                            {{/if}}
                            <a onclick="content.deletePoint(${item.id}, $(this))">Удалить</a>
                        </div>
                    </div>
                {{/each}}
            </div>
            <a class="button mini-btn" onclick="content.addPoint()">Добавить точку</a>
        </div>
    </script>

    <script id="teams" type="text/x-jquery-tmpl">
        <div class="teams-list">
            {{each(index, item) items}}
                <div class="team-item">
                    <div class="team-name">${item.description}</div>
                    <div class="team-actions">
                        <a onclick="content.showTeamPersons(${item.id})">Участники</a>
                        <a onclick="content.showTeamPoints(${item.id})">Точки</a>

                        {{if user.id == item.user_id}}
                            <a onclick="content.deleteTeam(${item.id})">Удалить</a>
                        {{else}}
                            <a class="team-remove" onclick="content.rejectInv(${item.id}, $(this))">Выйти</a>
                        {{/if}}
                    </div>
                </div>
            {{/each}}
        </div>
    </script>

    <script id="link-teams" type="text/x-jquery-tmpl">
        <div class="teams-list">
            {{each(index, item) items}}
                <div class="team-item">
                    <div class="team-name">${item.description}</div>
                    <div class="team-address">${item.address}</div>
                    <div class="team-actions">
                        <a onclick="content.linkWithThisTeam(${item.id}, ${point_id})">Выбрать</a>
                    </div>
                </div>
            {{/each}}
        </div>
    </script>

    <script id="profile" type="text/x-jquery-tmpl">
        <div class="main-info">
            <span class="user-id"><b>ID пользователя</b>${user.id}</span>
            <span class="user-name"><b>Имя пользователя</b>${user.username}</span>
            <a class="button mini-btn" onclick="auth.logOut()">Выйти</a>
        </div>
        <div class="invs-list">
            {{each(index, item) invs}}
                <div class="team-item">
                    <div class="team-name">
                        <b>Имя команды</b>${item.description}<br>
                        <b>Автор команды</b>${item.user.username}
                    </div>
                    <div class="team-actions">
                        <a onclick="content.acceptInv(${item.id}, $(this))">Принять</a>
                        <a class="team-reject" onclick="content.rejectInv(${item.id}, $(this))">Отклонить</a>
                    </div>
                </div>
            {{/each}}
        </div>
    </script>

    <script id="teams-persons" type="text/x-jquery-tmpl">
        <div class="team-persons">

            <a class="back" onclick="popups.slideDown($(this))">Назад</a>
            <div class="teams-persons-filter">
                <a onclick="content.showTeamPersons(${team_id})" class="{{if af == 'person' }}active-filter{{/if}}">Приняли приглашение</a>
                <a onclick="content.showTeamInvitations(${team_id})" class=" {{if af == 'inv' }}active-filter{{/if}}">Не приняли приглашение</a>
            </div>
            {{each(index, item) items}}
                <div class="team-person">
                    <div class="team-name">${item.user.username}</div>
                    <div class="team-actions">
                        <a onclick="content.removePersonFromTeam(${item.user.id})">Удалить</a>
                    </div>
                </div>
            {{/each}}

            <a class="button mini-btn" onclick="popups.addPersonInTeam(${team_id})">Добавить в команду</a>
        </div>
    </script>

</body>
</html>
@endverbatim