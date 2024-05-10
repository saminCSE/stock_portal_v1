@extends('layouts.master')
@section('market')
@if (session('status'))
    <div class="alert alert-success">{{ session('status')}}</div>
    @endif
<style>
    @font-face {
  font-family: "Muli-Regular";
  src: url("../fonts/muli/Muli-Regular.ttf"); }
@font-face {
  font-family: "Muli-SemiBold";
  src: url("../fonts/muli/Muli-SemiBold.ttf"); }
@font-face {
  font-family: "Muli-Bold";
  src: url("../fonts/muli/Muli-Bold.ttf"); }
* {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box; }

body {
  font-family: "Muli-Regular";
  color: #666;
  font-size: 13px;
  margin: 0; }

input, textarea, select, button {
  font-family: "Muli-Regular";
  color: #333;
  font-size: 22px; }

p, h1, h2, h3, h4, h5, h6, ul {
  margin: 0; }

img {
  max-width: 100%; }

ul {
  padding-left: 0;
  margin-bottom: 0; }

a:hover {
  text-decoration: none; }

:focus {
  outline: none; }

.wrapper {
  min-height: 100vh;
  background-size: cover;
  background-repeat: no-repeat;
  display: flex;
  align-items: center; }

.inner {
  min-width: 850px;
  margin: auto;
  padding-top: 68px;
  padding-bottom: 48px;
  background: url("../images/registration-form-2.jpg"); }
  .inner h3 {
    text-transform: uppercase;
    font-size: 22px;
    font-family: "Muli-Bold";
    text-align: center;
    margin-bottom: 32px;
    color: #333;
    letter-spacing: 2px; }

form {
  width: 50%;
  padding-left: 45px; }

.form-group {
  display: flex; }
  .form-group .form-wrapper {
    width: 50%; }
    .form-group .form-wrapper:first-child {
      margin-right: 20px; }

.form-wrapper {
  margin-bottom: 17px; }
  .form-wrapper label {
    margin-bottom: 9px;
    display: block; }

.form-control {
  border: 1px solid #ccc;
  display: block;
  width: 100%;
  height: 40px;
  padding: 0 20px;
  border-radius: 20px;
  font-family: "Muli-Bold";
  background: none; }
  .form-control:focus {
    border: 1px solid #ae3c33; }

select {
  -moz-appearance: none;
  -webkit-appearance: none;
  cursor: pointer;
  padding-left: 20px; }
  select option[value=""][disabled] {
    display: none; }


  form {
    width: 100%;
    padding-right: 15px;
    padding-left: 15px; }

/*# sourceMappingURL=style.css.map */
</style>
		<div class="wrapper">
			<div class="inner">
				<form action="{{route('market_schedule')}}" method="POST">
                @csrf
					<h3>Market Schedule Form</h3>
					<div class="form-group">
						<div class="form-wrapper">
						<label for="opendate">Open date:</label>
            <input type="date" id="open_date" name="open_date" value="Choose A date..." min="2022-01-01" max="2022-12-31">
						</div>
					</div>
					<div class="form-wrapper">
						<label for="opentime">Open Time</label>
                        <input type="time" id="open_time" name="open_time">
					</div>
                    <div class="form-group">
						<div class="form-wrapper">
						<label for="closedate">Close date:</label>
                        <input type="date" id="close_date" name="close_date" value="Choose A date..." min="2022-01-01" max="2022-12-31">
						</div>
					</div>
					<div class="form-wrapper">
						<label for="closetime">Close Time</label>
            <input type="time" id="close_time" name="close_time">
					</div>
            <div class="form-wrapper">
						<label for="comments">Comments</label>
            <textarea id="comments" name="comments" rows="4" cols="50"></textarea>
					</div>
					<button>Submit</button>
				</form>
			</div>
		</div>
@endsection