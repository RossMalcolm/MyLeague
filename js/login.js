var all_teams = []
        function login(){
            $.ajax({
            url: "https://cp465-my-league.herokuapp.com/api/login",  
            type: "POST",
            data:JSON.stringify({
                "league_name": document.getElementById("league_name").value,
                "password": document.getElementById("league_pass").value

            }),
            success:function(result){
                var data = JSON.parse(result); 
                sessionStorage.setItem('loggedIn', true);
                sessionStorage.setItem("leagueID", data.league_id);
                window.location.replace("../html/leaderboard.html");
                window.location.replace("../html/manage.html")
                
                },
            error:function(xhr, status, error) {
                alert("Could not Login");
                }
            });
        }

        function create_league(){
            $.ajax({
            url: "https://cp465-my-league.herokuapp.com/api/leagues",  
            type: "POST",
            data:JSON.stringify({
                "league_name": document.getElementById("league_name_create").value,
                "team_names": all_teams.join(),
                "password": document.getElementById("league_pass_create").value
            }),
            success:function(result){
                var data = JSON.parse(result);   
                sessionStorage.setItem('loggedIn', true); 
                sessionStorage.setItem("leagueID", data.league_id);
                window.location.replace("../html/manage.html");
                sessionStorage.setItem("teamNames", JSON.stringify(all_teams));
                },
            error:function(xhr, status, error) {
                alert("League Already Exists");
                
                }
            });
        }

        function addTeam(){
            var list = document.getElementById("teams_list");
            var name = document.getElementById("team_names").value;
            all_teams.push(name);
            list.innerHTML += ("<li>"+name+"</li>");
        }