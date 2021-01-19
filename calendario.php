<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/calendar.css" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="js/hiddenContent.js"></script>
    <title>Document</title>
  </head>
  <body>
    <header>
      <div class="headerLeft">
          <div class="logoContainer">
              <a href="home.html">
                  <p>Logotipo</p>
              </a>
          </div>
          <div class="navbar">
              
              <a href="home.html" class="navBarItem">Homepage</a>
              <a href="disciplinas.html" class="navBarItem">Disciplinas</a>
              <a href="calendario.html" class="navBarItem">Calendario</a>
          </div>
      </div>
      <div class="headerProfile">
          <div class="dropdownBox">
              <img class="profileNotificacoes " src="images/bell.png" alt="">
              <div id="notificacoesMenu" class="notificacoesMenu ">
                  <p>
                      Prof.Paulo Lava. É para entregar...
                  </p>
                  <p>
                      Prof.Paulo Lava. É para entregar...
                  </p>
                  <p>
                      Prof.Paulo Lava. É para entregar...
                  </p>
                  <p>
                      Prof.Paulo Lava. É para entregar...
                  </p>
                  <a href="" class="notificacoesBtn">
                      Todas
                  </a>
              </div>
            </div>
          
          <div class="dropdownBoxProfile">
              <a  href="profile.html"><img class="profileImg " src="images/user.png" alt=""></a>
              <div id="profileMenu" class="profileMenus">
                <a href="#">Perfil</a>
                <a href="#">Definições</a>
                <a href="#">logout</a>
              </div>
            </div>

      </div>
      
  </header>

    <div class="hiddenDivs">
      <div class="addCompromissoContainer" id="addCompromissoContainer">
        <div class="tituloWindow">
          <div class="descricaoWindow">
            <h2>Data: 20/10/1921</h2>
          </div>
          <div class="exitWindow">
            <img src="images/fechar.png" onclick="addCompromisso()" />
          </div>
        </div>
        <div class="tituloCompromissos">
          <p>Compromissos:</p>
        </div>
        <div class="listaCompromissos">
          <div class="CompromissoRow">
            <p>Reunião de professores - 19.30</p>
          </div>
          <div class="CompromissoRow">
            <p>Reunião de professores - 19.30</p>
          </div>
        </div>
        <div class="addCompromisso">
            <form action="" method="GET">
                <div class="tituloCompromissos">
                    <p>Novo compromisso:</p>
                </div>
                <div class="inputCompromissos">
                    <input type="text" name="nomeCompromisso" placeholder="INSIRA UM NOME">
                    <div class="tempoCompromisso">
                        <label for="horaCompromisso">Hora:</label>
                    <input type="time" name="horaCompromisso">
                    </div>
                    <button type="submit"><img src="images/plus.png" alt=""></button>
                </div>
                <div class="DisciplinaCompromisso">
                    <label for="">Disciplina:</label>
                    <select name="listaDisciplinas">
                        <option value="none">Selecione uma disciplina</option>
                        <option value="Matematica">Matematica</option>
                        <option value="DocumentacaoTecnica">Documentação Técnica</option>
                    </select>
                </div>
            </form>
            
            <div class="notificarCompromisso">
                <div class="txtnotificar">
                    <p>Já existe um compromisso, deseja notificar?</p>
                </div>
                <div class="btnNotificar">
                    <button type="">Notificar</button>
                </div>
            </div>
        </div>
      </div>
    </div>

    <div class="mainContainer">
      <h1>
        Mês - Janeiro de 2021
      </h1>
      <div class="main-content">
        <div class="date" onclick="addCompromisso()">1</div>
        <div class="date" onclick="addCompromisso()">2</div>
        <div class="date" onclick="addCompromisso()">
          3 <br />
          Entrega do relatório de Engenharia de Software
        </div>
        <div class="date">4</div>
        <div class="date">5</div>
        <div class="date">6</div>
        <div class="date">7</div>
        <div class="date">8</div>
        <div class="date">9</div>
        <div class="date">10</div>
        <div class="date">11</div>
        <div class="date">12</div>
        <div class="date">13</div>
        <div class="date">14</div>
        <div class="date">15</div>
        <div class="date">
          16 <br />
          Teste de Big Data
        </div>
        <div class="date">17</div>
        <div class="date">18</div>
        <div class="date">19</div>
        <div class="date">20</div>
        <div class="date">21</div>
        <div class="date">22</div>
        <div class="date">23</div>
        <div class="date">
          24 <br />
          Defesa de Documentação Técnica
        </div>
        <div class="date">25</div>
        <div class="date">26</div>
        <div class="date">27</div>
        <div class="date">28</div>
        <div class="date">29</div>
        <div class="date">30</div>
        <div class="date">31</div>
      </div>
    </div>
  </body>
</html>
