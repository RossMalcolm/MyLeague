function onLoadFnc() {
    // ONLOAD script

    var isLoggedIn = sessionStorage.getItem("loggedIn") || false;

    if (isLoggedIn) {
        var login = document.getElementById("login");
        login.style.display = 'none';
    }
    else {
        var logout = document.getElementById('logout');
        logout.style.display = 'none';

        var manage = document.getElementById('manage');
        manage.style.display = 'none';
    }
}

function sortTable(n) {
    // Taken and slightly modified from https://www.w3schools.com/howto/howto_js_sort_table.asp
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById("leagueTable");
        switching = true;
        dir = "asc";
        while (switching) {
            switching = false;
            rows = table.rows;
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("td")[n];
                y = rows[i + 1].getElementsByTagName("td")[n];
                if (isNaN(x.innerHTML)==true){
                    if (dir == "asc") {
                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    } 
                    else if (dir == "desc") {
                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
                else{
                    if (dir == "asc") {
                    if (parseInt(x.innerHTML) > parseInt(y.innerHTML)) {
                        shouldSwitch = true;
                        break;
                    }
                } 
                else if (dir == "desc") {
                    if (parseInt(x.innerHTML) < parseInt(y.innerHTML)) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
           
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchcount ++;
        } else {
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}

function logout() {
    sessionStorage.removeItem("loggedIn");
    sessionStorage.removeItem("leagueID");
    sessionStorage.removeItem("teamNames");
    sessionStorage.removeItem('game_id');
    sessionStorage.removeItem('game_time');
    window.location.replace("../html/index.html");
}
