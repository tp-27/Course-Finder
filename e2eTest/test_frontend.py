import re
from time import sleep
from playwright.sync_api import Page, expect, sync_playwright

# Tests the navbar to see if it's take the user to the correct places
def test_navbar(page: Page):
    page.goto("https://cis3760f23-04.socs.uoguelph.ca")
    expect(page.get_by_text("F_23_CIS3760: Group_104")).to_be_visible()
    expect(page.get_by_role("link",name="Features")).to_be_visible()
    expect(page.get_by_role("link",name="Setup")).to_be_visible()
    expect(page.get_by_role("link",name="Using the Software")).to_be_visible()
    expect(page.get_by_role("link",name="Team")).to_be_visible()
    expect(page.get_by_role("link",name="Api Documentation")).to_be_visible()
    expect(page.get_by_text("104", exact=True)).to_be_visible()
    expect(page.get_by_text("F_23_CIS3760: Group_104")).to_be_visible()
    expect(page.get_by_text("Welcome to Group 104's PHP-powered homepage, where innovation and collaboration ")).to_be_visible()
    expect(page.get_by_text("Introducing VBA Induced Student Course Management Tool")).to_be_visible()
    page.get_by_role("link", name="Features").click()
    page.get_by_role("link", name="Setup").click()
    page.get_by_role("link", name="Using the Software").click()
    page.get_by_role("link", name="Team").click()
    page.get_by_role("link", name="Api Documentation").click()
    page.goto("https://cis3760f23-04.socs.uoguelph.ca")
    page.get_by_role("link", name="Api Frontend").click()
    page.goto("https://cis3760f23-04.socs.uoguelph.ca")


# Tests the landing page
def test_landing(page: Page):
    page.goto("https://cis3760f23-04.socs.uoguelph.ca")
    page.get_by_role("link", name="Setup").click()
    expect(page.get_by_role("heading", name="Step 1: Download The Software")).to_be_visible()
    expect(page.locator("#setup").get_by_role("img").first).to_be_visible()
    expect(page.get_by_role("heading", name="Step 2: Enable Permissions")).to_be_visible()
    expect(page.locator("#setup").get_by_role("img").nth(1)).to_be_visible()
    expect(page.get_by_role("heading", name="Step 3: Open the excel workbook")).to_be_visible()
    expect(page.locator("#setup").get_by_role("img").nth(2)).to_be_visible()


# Tests the getting started
def test_getting_start(page:Page):
    page.goto("https://cis3760f23-04.socs.uoguelph.ca")
    expect(page.get_by_role("link", name="Using the Software")).to_be_visible()
    expect(page.get_by_role("heading", name="Using The Software")).to_be_visible()
    expect(page.get_by_role("heading", name="Step 1: Enter Your Courses")).to_be_visible()
    expect(page.get_by_role("heading", name="Step 2: Generate & View The eligible courses")).to_be_visible()
    expect(page.get_by_role("heading", name="Step 3: Delete Unwanted Courses")).to_be_visible()
    expect(page.locator("#using").get_by_role("img").first).to_be_visible()
    expect(page.locator("#using").get_by_role("img").nth(1)).to_be_visible()
    expect(page.locator("#using").get_by_role("img").nth(2)).to_be_visible()

# Tests to see if frontend components exists on the APIFrontend page
def test_Api_front_end_components(page:Page):
    page.goto("https://cis3760f23-04.socs.uoguelph.ca/pages/ApiFrontend/")
    expect(page.get_by_role("heading", name="Course Finder")).to_be_visible()
    expect(page.get_by_role("img", name="Person reading script")).to_be_visible()
    expect(page.get_by_role("heading", name="1. Add your completed courses")).to_be_visible()
    expect(page.get_by_role("columnheader", name="select")).to_be_visible()
    expect(page.locator("#courseList").get_by_role("columnheader", name="courseCode")).to_be_visible()
    expect(page.locator("#courseList").get_by_role("columnheader", name="courseName")).to_be_visible()
    expect(page.get_by_text("Your completed courses:")).to_be_visible()
    expect(page.get_by_role("heading", name="2. Click generate to view eligible courses")).to_be_visible()
    expect(page.get_by_role("button", name=" Filters")).to_be_visible()
    page.get_by_role("button", name=" Filters").click()
    expect(page.get_by_role("button", name="SUBJECT")).to_be_visible()
    expect(page.get_by_role("button", name="LEVEL")).to_be_visible()
    expect(page.get_by_role("button", name="Apply")).to_be_visible()
    expect(page.get_by_role("button", name="Generate")).to_be_visible()

# Test the tables of courses on the page
def test_course_table(page:Page):
    page.goto("https://cis3760f23-04.socs.uoguelph.ca/pages/ApiFrontend/")
    page.get_by_role("row", name="CIS*1300 Programming").get_by_role("checkbox").check()
    page.get_by_role("button", name="Close").click()

def test_course_table_grade(page:Page):
    page.goto("https://cis3760f23-04.socs.uoguelph.ca/pages/ApiFrontend/")
    page.get_by_role("row", name="CIS*1300 Programming").get_by_role("checkbox").check()
    page.get_by_placeholder("Enter here").click()
    page.get_by_placeholder("Enter here").fill("100")
    page.get_by_role("button", name="Save Grade").click()
    page.get_by_role("row", name="CIS*1300 Programming").get_by_role("checkbox").uncheck()

def test_course_table_grade_function_error(page:Page):
    page.goto("https://cis3760f23-04.socs.uoguelph.ca/pages/ApiFrontend/")
    page.get_by_role("row", name="CIS*1300 Programming").get_by_role("checkbox").check()
    page.get_by_placeholder("Enter here").click()
    page.get_by_placeholder("Enter here").fill("0")
    page.once("dialog", lambda dialog: dialog.dismiss())
    page.get_by_role("button", name="Save Grade").click()
    page.get_by_placeholder("Enter here").click()
    page.get_by_placeholder("Enter here").fill("100")
    page.get_by_role("button", name="Save Grade").click()
def test_search_course_function(page:Page):
    page.goto("https://cis3760f23-04.socs.uoguelph.ca/pages/ApiFrontend/")
    page.get_by_placeholder("Search courses...").click()
    page.locator("#possibleCoursesSearchInput").fill("CIS*1300")
    page.get_by_role("button", name="Search").click()
    page.get_by_role("checkbox").check()
    page.get_by_placeholder("Enter here").click()
    page.get_by_placeholder("Enter here").fill("100")
    page.get_by_role("button", name="Save Grade").click()
    page.get_by_role("button", name="Restore Courses").click()
    page.locator("#possibleCoursesSearchInput").click()
    page.locator("#possibleCoursesSearchInput").fill("Programming")
    page.get_by_role("button", name="Search").click()
    page.get_by_role("cell", name="Programming", exact=True).click()
    page.get_by_role("cell", name="CIS*1300").click()

def test_search_course_function_error(page:Page):
    page.goto("https://cis3760f23-04.socs.uoguelph.ca/pages/ApiFrontend/")
    page.get_by_placeholder("Search courses...").click()
    page.locator("#possibleCoursesSearchInput").fill("CIS*13")
    page.get_by_role("button", name="Search").click()
    page.get_by_text("Invalid course code").click()
    page.locator("#possibleCoursesSearchInput").click()
    page.locator("#possibleCoursesSearchInput").fill("CIS*1300")
    page.get_by_role("button", name="Search").click()
    page.get_by_role("checkbox").check()
    page.get_by_placeholder("Enter here").click()
    page.get_by_placeholder("Enter here").fill("70")

def test_display_credit_grades(page:Page):
    page.goto("https://cis3760f23-04.socs.uoguelph.ca/pages/ApiFrontend/")
    page.get_by_placeholder("Search courses...").click()
    page.locator("#possibleCoursesSearchInput").fill("CIS*1300")
    page.get_by_role("button", name="Search").click()
    page.get_by_role("checkbox").check()
    page.get_by_placeholder("Enter here").click()
    page.get_by_placeholder("Enter here").fill("100")
    page.get_by_role("button", name="Save Grade").click()
    page.get_by_role("button", name="Restore Courses").click()
    page.get_by_role("row", name="ACCT*1220 Introductory Financial Accounting").get_by_role("checkbox").check()
    page.get_by_placeholder("Enter here").click()
    page.get_by_placeholder("Enter here").fill("100")
    page.get_by_role("button", name="Save Grade").click()
    page.get_by_text("Your completed courses: (Total Credits: 1, Average: 100.00)Clear Courses").click()

def test_clear_courses(page:Page):
    page.goto("https://cis3760f23-04.socs.uoguelph.ca/pages/ApiFrontend/")
    page.get_by_placeholder("Search courses...").click()
    page.locator("#possibleCoursesSearchInput").fill("CIS*1300")
    page.get_by_role("button", name="Search").click()
    page.get_by_role("checkbox").check()
    page.get_by_placeholder("Enter here").click()
    page.get_by_placeholder("Enter here").fill("75")
    page.get_by_role("button", name="Save Grade").click()
    page.get_by_text("Your completed courses: (Total Credits: 0.5, Average: 75.00)Clear Courses").click()
    page.get_by_role("heading", name="1) CIS*1300 - Programming - Grade: 75").click()
    page.get_by_role("button", name="Clear Courses").click()
    page.get_by_text("Your completed courses: (Total Credits: 0, Average: 0.00)").click()

# Tests CIS*1300 search to see if we come back with the correct results
def test_course_search(page:Page):
    page.goto("https://cis3760f23-04.socs.uoguelph.ca/pages/ApiFrontend/")
    page.get_by_placeholder("Search courses...").click()
    page.locator("#possibleCoursesSearchInput").fill("CIS*1300")
    page.get_by_role("button", name="Search").click()
    page.get_by_role("checkbox").check()
    page.get_by_placeholder("Enter here").click()
    page.get_by_placeholder("Enter here").fill("100")
    page.get_by_role("button", name="Save Grade").click()
    page.get_by_role("button", name="Generate").click()
    count = page.locator("#eligibleCourseListBody").locator('tr').count()
    assert count == 11

# Test if we can check and uncheck CIS*1300 box 
def test_course_delete(page:Page):
    page.goto("https://cis3760f23-04.socs.uoguelph.ca/pages/ApiFrontend/")
    page.get_by_placeholder("Search courses...").click()
    page.locator("#possibleCoursesSearchInput").fill("CIS*1300")
    page.get_by_role("button", name="Search").click()
    page.get_by_role("checkbox").check()
    page.get_by_placeholder("Enter here").click()
    page.get_by_placeholder("Enter here").fill("100")
    page.get_by_role("button", name="Save Grade").click()
    page.get_by_text("Your completed courses: (Total Credits: 0.5, Average: 100.00)Clear Courses").click()
    page.get_by_role("heading", name="1) CIS*1300 - Programming - Grade: 100").click()
    page.get_by_role("button", name="Clear Courses").click()
    page.get_by_text("Your completed courses: (Total Credits: 0, Average: 0.00)").click()
    page.get_by_role("checkbox").check()
    page.get_by_placeholder("Enter here").click()
    page.get_by_placeholder("Enter here").fill("100")
    page.get_by_role("button", name="Save Grade").click()
    page.get_by_role("checkbox").uncheck()
    page.get_by_text("Your completed courses: (Total Credits: 0, Average: 0.00)").click()
    page.get_by_role("checkbox").check()
    page.get_by_placeholder("Enter here").click()
    page.get_by_placeholder("Enter here").fill("50")
    page.get_by_role("button", name="Save Grade").click()
    page.get_by_text("Your completed courses: (Total Credits: 0.5, Average: 50.00)Clear Courses").click()
    page.get_by_role("heading", name="1) CIS*1300 - Programming - Grade: 50").click()
    page.get_by_role("button", name="Generate").click()
    count = page.locator("#eligibleCourseListBody").locator('tr').count()
    assert count == 6


def test_report_download(page:Page):
    page.goto("https://cis3760f23-04.socs.uoguelph.ca/pages/ApiFrontend/")
    page.get_by_placeholder("Search courses...").click()
    page.locator("#possibleCoursesSearchInput").fill("CIS*1300")
    page.get_by_role("button", name="Search").click()
    page.get_by_role("checkbox").check()
    page.get_by_placeholder("Enter here").click()
    page.get_by_placeholder("Enter here").fill("100")
    page.get_by_role("button", name="Save Grade").click()
    page.get_by_text("Your completed courses: (Total Credits: 0.5, Average: 100.00)Clear Courses").click()
    page.get_by_role("heading", name="1) CIS*1300 - Programming - Grade: 100").click()
    page.get_by_role("button", name="Generate").click()
    with page.expect_download() as download_info:
        page.get_by_role("button", name="Download Report").click()
    download = download_info.value

    assert download != None

def test_delete_table_row(page:Page):
    page.goto("https://cis3760f23-04.socs.uoguelph.ca/pages/ApiFrontend/")
    page.get_by_placeholder("Search courses...").click()
    page.locator("#possibleCoursesSearchInput").fill("CIS*1300")
    page.get_by_role("button", name="Search").click()
    page.get_by_role("checkbox").check()
    page.get_by_placeholder("Enter here").click()
    page.get_by_placeholder("Enter here").fill("100")
    page.get_by_role("button", name="Save Grade").click()
    page.get_by_text("Your completed courses: (Total Credits: 0.5, Average: 100.00)Clear Courses").click()
    page.get_by_role("heading", name="1) CIS*1300 - Programming - Grade: 100").click()
    page.get_by_role("button", name="Generate").click()
    page.get_by_role("button", name=" Filters").click()
    page.get_by_role("button", name="SUBJECT").click()
    page.get_by_label("CIS").check()
    page.get_by_role("button", name="LEVEL").click()
    page.get_by_label("2000").check()
    page.get_by_role("button", name="Apply").click()
    count = page.locator("#eligibleCourseListBody").locator('tr').count()
    assert count == 2
    page.get_by_role("row", name="CIS*2500 Intermediate Programming In this course students learn to interpret a program specification and implement it as reliable code, as they gain experience with pointers, complex data types, important algorithms, intermediate tools and techniques in problem solving, programming, and program testing. 0.50 Guelph x").get_by_role("button").click()
    count = page.locator("#eligibleCourseListBody").locator('tr').count()
    assert count == 1


# Test if we can filter out courses with Operating Systems.
def test_course_filter(page:Page):
    page.goto("https://cis3760f23-04.socs.uoguelph.ca/pages/ApiFrontend/")
    page.get_by_placeholder("Search courses...").click()
    page.locator("#possibleCoursesSearchInput").fill("CIS*3110")
    page.get_by_role("button", name="Search").click()
    page.get_by_role("checkbox").check()
    page.get_by_placeholder("Enter here").click()
    page.get_by_placeholder("Enter here").fill("100")
    page.get_by_role("button", name="Save Grade").click()
    page.get_by_text("Your completed courses: (Total Credits: 0.5, Average: 100.00)Clear Courses").click()
    page.get_by_role("heading", name="1) CIS*3110 - Operating Systems I - Grade: 100").click()
    page.get_by_role("button", name="Generate").click()
    page.get_by_role("button", name=" Filters").click()
    page.get_by_role("button", name="SUBJECT").click()
    page.get_by_role("button", name="LEVEL").click()
    page.get_by_role("button", name="CREDITS").click()
    page.get_by_role("button", name="SUBJECT").click()
    page.locator("div").filter(has_text=re.compile(r"^BIOL$")).click()
    page.locator("div").filter(has_text=re.compile(r"^CIS$")).click()
    page.locator("div").filter(has_text=re.compile(r"^ENVS$")).click()
    page.locator("div").filter(has_text=re.compile(r"^GEOG$")).click()
    page.locator("div").filter(has_text=re.compile(r"^MATH$")).click()
    page.locator("div").filter(has_text=re.compile(r"^POLS$")).click()
    page.get_by_label("POLS").uncheck()
    page.get_by_label("MATH").uncheck()
    page.get_by_label("GEOG").uncheck()
    page.get_by_label("ENVS").uncheck()
    page.get_by_label("BIOL").uncheck()
    page.get_by_label("CIS").check()
    page.get_by_role("button", name="LEVEL").click()
    page.locator("div").filter(has_text=re.compile(r"^2000$")).click()
    page.get_by_label("3000").check()
    page.get_by_label("4000").check()
    page.get_by_label("4000").uncheck()
    page.get_by_label("3000").uncheck()
    page.get_by_label("2000").uncheck()
    page.get_by_label("3000").check()
    page.get_by_role("button", name="CREDITS").click()
    page.locator("div").filter(has_text=re.compile(r"^0\.75$")).click()
    page.locator("div").filter(has_text=re.compile(r"^0\.50$")).click()
    page.locator("div").filter(has_text=re.compile(r"^1\.00$")).click()
    page.locator("div").filter(has_text=re.compile(r"^1\.00$")).click()
    page.get_by_label("0.75").uncheck()


    page.get_by_role("button", name="Apply").click()
    count = page.locator("#eligibleCourseListBody").locator('tr').count()
    assert count == 2

    page.get_by_role("button", name="LEVEL").click()
    page.get_by_label("3000").uncheck()
    page.get_by_label("4000").check()
    page.get_by_role("button", name="Apply").click()
    count = page.locator("#eligibleCourseListBody").locator('tr').count()
    assert count == 1
   

# This tests for the Tree component to see if the basic html components are visible
def test_my_app(page:Page):

    page.goto("https://cis3760f23-04.socs.uoguelph.ca/pages/ApiTree/")
    expect(page.get_by_role("img", name="map")).to_be_visible() 
    expect(page.get_by_role("button", name="Select Subject")).to_be_visible() 
    page.get_by_role("button", name="Select Subject").click()
    page.get_by_role("button", name="Select Subject").click()
    expect(page.get_by_text("Course Mapper")).to_be_visible() 
    page.get_by_text("CIS").click()
    expect(page.get_by_text("Selected Subject: CIS")).to_be_visible() 

# This tests for the generate tree for all the CIS courses
def test_tree_components(page:Page, assert_snapshot):
    
    page.goto("https://cis3760f23-04.socs.uoguelph.ca/pages/ApiTree/")
    page.get_by_role("img", name="map").click()
    page.get_by_role("button", name="Select Subject").click()
    page.get_by_role("button", name="Select Subject").click()
    page.get_by_text("Course Mapper").click()
    page.get_by_text("CIS").click()

    graph_element = page.locator('body')
    bounding_box = graph_element.bounding_box()
    center_x = bounding_box['x'] + bounding_box['width'] / 2
    center_y = bounding_box['y'] + bounding_box['height'] / 2
    page.mouse.move(center_x+500, center_y+500)
    page.mouse.wheel(0,1000)
    sleep(1)
    # Screenshot the page and check if the screenshot matches
    assert_snapshot(page.screenshot(), threshold=0.8, fail_fast=False,name =' test_tree_components[chromium][darwin][0].png')

#This tests for the generated tree but also tests if the user can click on the tree to see what courses is needed
def test_tree_components_highlight(page:Page, assert_snapshot):
    page.goto("https://cis3760f23-04.socs.uoguelph.ca/pages/ApiTree/")
    page.get_by_role("img", name="map").click()
    page.get_by_role("button", name="Select Subject").click()
    page.get_by_role("button", name="Select Subject").click()
    page.get_by_text("Course Mapper").click()
    page.get_by_text("CIS").click()

    graph_element = page.locator('body')
    bounding_box = graph_element.bounding_box()
    center_x = bounding_box['x'] + bounding_box['width'] / 2
    center_y = bounding_box['y'] + bounding_box['height'] / 2
    page.mouse.move(center_x+500, center_y+500)
    page.mouse.wheel(0,1000)
    page.locator("canvas").click(position={"x":110,"y":621})
    assert_snapshot(page.screenshot(), threshold=0.8, fail_fast=False,name =' test_tree_components_highlight[chromium][darwin][0].png' )
    page.locator("canvas").click(position={"x":133,"y":623})
    assert_snapshot(page.screenshot(), threshold=0.8, fail_fast=False,name =' test_tree_components_highlight[chromium][darwin][1].png' )