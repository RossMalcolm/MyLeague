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
                console.log("added", data.league_id);
                console.log("leagueId set to ", sessionStorage.getItem("leagueID"))
                window.location.replace("../html/manage.html")
                
                },
            error:function(xhr, status, error) {
                alert("Could not be Logged in");
                }
            });
        }

        function create_league(){
            if(document.getElementById("league_name_create").value != "" && all_teams.length > 1 && document.getElementById("league_pass_create").value != ""){
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
                        console.log("added", data.league_id);
                        console.log("leagueId set to ", sessionStorage.getItem("leagueID"))
                        window.location.replace("../html/manage.html");
                        },
                    error:function(xhr, status, error) {
                        alert("League Already Exists");
                        
                        }
                    });
            }else if (document.getElementById("league_name_create").value == "" || document.getElementById("league_pass_create").value == ""){
                alert("League Name and Password cannot be blank");
            }else{
                alert("Must select more than 1 team");
            }
        }

        function addTeam(){
            if (document.getElementById("team_names").value != ""){
                var list = document.getElementById("teams_list");
                var name = document.getElementById("team_names").value;
                all_teams.push(name);
                list.innerHTML += ("<li>"+name+"</li>");
            }else{
                alert("Teams must have a name");
            }
            
        }