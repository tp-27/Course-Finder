from playwright.sync_api import sync_playwright

def test_load_courses_start(playwright: sync_playwright):
    context = playwright.request.new_context()
    response = context.get('https://cis3760f23-04.socs.uoguelph.ca/api/loadcourses/loadcourses.php')
    assert response.ok
    assert response.status == 200

def test_run_search(playwright: sync_playwright):
    context = playwright.request.new_context()
    data = {
    "id":"CIS*1300"
    }
    response = context.post("https://cis3760f23-04.socs.uoguelph.ca/api/Course/Course",data = data)
    
    assert response.ok
    assert response.status == 200
    assert response.headers["content-type"] == "application/json"
    assert response.body()

def test_multi_param_search(playwright: sync_playwright):
    context = playwright.request.new_context()
    data = {
    "name":"Programming",
    "credits":0.5,
    "location": "Guelph"
    }
    response = context.post("https://cis3760f23-04.socs.uoguelph.ca/api/Course/Course",data = data)
    assert response.ok
    assert response.status == 200
    assert response.headers["content-type"] == "application/json"
    assert response.json()

def test_run_no_params(playwright: sync_playwright):
    context = playwright.request.new_context()
    response = context.post("https://cis3760f23-04.socs.uoguelph.ca/api/Course/Course")
    assert response.ok
    assert response.status == 200
    assert response.headers["content-type"] == "application/json"
    assert response.json()

def test_run_invalid(playwright: sync_playwright):
    context = playwright.request.new_context()
    data = {
    "id":"CIS*5000",
    }
    response = context.post("https://cis3760f23-04.socs.uoguelph.ca/api/Course/Course")
    assert response.ok
    assert response.status == 200
    assert response.headers["content-type"] == "application/json"
    assert response.json()

def test_run_invalid_link(playwright: sync_playwright):
    context = playwright.request.new_context()
    response = context.get("https://cis3760f23-04.socs.uoguelph.ca/api")
    assert response.status == 403 or response.status == 404
    assert response.status_text == 'Forbidden' or response.status_text == 'Not Found'

def test_run_get_subjects(playwright: sync_playwright):
    context = playwright.request.new_context()
    response = context.get("http://cis3760f23-04.socs.uoguelph.ca/api/getSubjects/getSubjects.php")
    assert response.ok
    assert response.status == 200
    assert response.headers["content-type"] == "application/json"
    assert response.json() 

def test_run_invalid_link(playwright: sync_playwright):
    context = playwright.request.new_context()
    response = context.get("https://cis3760f23-04.socs.uoguelph.ca/api")
    assert response.status == 403 or response.status == 404
    assert response.status_text == 'Forbidden' or response.status_text == 'Not Found'

def test_get_possible_courses(playwright: sync_playwright):
    context = playwright.request.new_context()
    data = {
    "coursesTaken":[]
    }
    response = context.post("https://cis3760f23-04.socs.uoguelph.ca/api/Course/getPossibleCourses.php",data = data)
    assert response.ok
    assert response.status == 200
    assert response.json()
    data = {
    "coursesTaken":["CIS*1300"]
    }
    response = context.post("https://cis3760f23-04.socs.uoguelph.ca/api/Course/getPossibleCourses.php",data = data)
    assert response.ok
    assert response.status == 200
    assert response.json()


def test_get_possible_courses_with_credit(playwright: sync_playwright):
    context = playwright.request.new_context()
    data = {
    "coursesTaken":[],
    "credits": 0.00,
    }
    response = context.post("https://cis3760f23-04.socs.uoguelph.ca/api/Course/getPossibleCourses.php",data = data)
    assert response.ok
    assert response.status == 200
    assert response.json()
    data = {
    "coursesTaken":["CIS*1300"],
    "credits": 0.5,
    }
    response = context.post("https://cis3760f23-04.socs.uoguelph.ca/api/Course/getPossibleCourses.php",data = data)
    assert response.ok
    assert response.status == 200
    assert response.json()


def test_get_possible_courses_with_average(playwright: sync_playwright):
    context = playwright.request.new_context()
    data = {
    "coursesTaken":["CIS*1300"],
    "average": 50.0,
    }
    response = context.post("https://cis3760f23-04.socs.uoguelph.ca/api/Course/getPossibleCourses.php",data = data)
    assert response.ok
    assert response.status == 200
    assert response.json()
    data = {
    "coursesTaken":["CIS*1300"],
    "average": 100.0,
    }
    response = context.post("https://cis3760f23-04.socs.uoguelph.ca/api/Course/getPossibleCourses.php",data = data)
    assert response.ok
    assert response.status == 200
    assert response.json()

def test_get_possible_courses_with_average_and_credit(playwright: sync_playwright):
    context = playwright.request.new_context()
    data = {
    "coursesTaken":["CIS*1300"],
    "credits": 0.5,
    "average": 50.0,
    }
    response = context.post("https://cis3760f23-04.socs.uoguelph.ca/api/Course/getPossibleCourses.php",data = data)
    assert response.ok
    assert response.status == 200
    assert response.json()
    data = {
    "coursesTaken":["CIS*1300","CIS*2500"],
    "average": 100.0,
    "credits": 1.00,
    }
    response = context.post("https://cis3760f23-04.socs.uoguelph.ca/api/Course/getPossibleCourses.php",data = data)
    assert response.ok
    assert response.status == 200
    assert response.json()

def test_delete_course(playwright: sync_playwright):
    context = playwright.request.new_context()
    data = [
            "CIS*1300"
        ]
    response = context.delete("https://cis3760f23-04.socs.uoguelph.ca/api/Course/Course.php",data = data)
    assert response.ok
    assert response.status == 200
    assert response.body()
    response = context.delete("https://cis3760f23-04.socs.uoguelph.ca/api/Course/Course.php",data = data)
    assert response.ok
    assert response.status == 200
    assert response.body()
    response = context.delete("https://cis3760f23-04.socs.uoguelph.ca/api/Course/Course.php")
    assert response.status == 400
    assert response.body()


def test_load_courses(playwright: sync_playwright):
    context = playwright.request.new_context()
    response = context.get('https://cis3760f23-04.socs.uoguelph.ca/api/loadcourses/loadcourses.php')
    assert response.ok
    assert response.status == 200
