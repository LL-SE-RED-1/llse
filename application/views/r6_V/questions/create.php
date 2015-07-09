     <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<h1 class="page-header"><?php echo $title ?></h1>

        <div class="table-responsive">
            
			<form action='<?php echo site_url('r6_C/welcome/welc');?>' method='post'>
			<input type='submit' class="btn btn-default" value='返回'>
			<br></form>
			
				<?php echo validation_errors(); ?>
				<?php echo form_open('r6_C/questions/create') ?>
				<!-- <input type="button" name="btn" value="返回" onclick="location.href='..\index.php'"><br /><br /> -->

				  <!-- <label for="title">TID</label> <br /> -->
				  <!-- <input type="input" name="TID" required="required" value="<?php echo set_value('TID'); ?>" /><br /> -->
					<input type="hidden" name="TID" required="required" value="<?php echo $this->session->userdata('tid');?>" />

				  <label for="text">课程选择</label>
				  <!-- <input type="input" name="CID" required="required" value="<?php echo set_value('CID'); ?>"/><br /> -->
					<select name='CID' value=''>
					<?php
						foreach($cous as $co){
							echo "<option value=".$co->course_id.">".$co->course_name."</option>";
						}
					?>
					</select>
					<br />

				  <label for="text">题目正文</label><br />
				  <textarea name="QUESTION" required="required" rows="4" cols="80"><?php echo set_value('QUESTION'); ?></textarea><br />
					<br />

				  <label for="text">题目类型</label><br />
				  <select name="TYPE" id="TYPE" onchange="type_select()" value="<?php echo set_value('TYPE'); ?>">
					<option value="CHOICE">选择题</option>
					<option value="JUDGE">判断题</option>
				  </select>
				  <br />
					<div id="CHOICES">
						<br />
						<label for="text" >选项设置</label><br />
						<span style="width:40px;display:-moz-inline-box;display:inline-block;color:black;">A: </span> <input type="input" name="SELECT_A" value="<?php echo set_value('SELECT_A'); ?>" size="70"/><br />
						<span style="width:40px;display:-moz-inline-box;display:inline-block;color:black;">B: </span> <input type="input" name="SELECT_B" value="<?php echo set_value('SELECT_B'); ?>" size="70"/><br />
						<span style="width:40px;display:-moz-inline-box;display:inline-block;color:black;">C: </span> <input type="input" name="SELECT_C" value="<?php echo set_value('SELECT_C'); ?>" size="70"/><br />
						<span style="width:40px;display:-moz-inline-box;display:inline-block;color:black;">D: </span> <input type="input" name="SELECT_D" value="<?php echo set_value('SELECT_D'); ?>" size="70"/><br />
					</div>
					<br />
				  <label for="text">答案</label><br />
				<!--   <select name="KEY" id="KEY" required="required" value="<?php echo set_value('KEY'); ?>">
					<option value="A" id="A">A</option>
					<option value="B" id="B">B</option>
					<option value="C" id="C">C</option>
					<option value="D" id="D">D</option>
					<option value="T" id="T" style="display:none;">T</option>
					<option value="F" id="F" style="display:none;">F</option>
				  </select> -->
					<span id="A" style="width:40px;display:-moz-inline-box;display:inline-block;color:black;"><input type="checkbox" id="SA" name="KEY[]" value="1" /><font size="5">&nbsp;A </font></span>
					<span id="B" style="width:40px;display:-moz-inline-box;display:inline-block;color:black;"><input type="checkbox" id="SB" name="KEY[]" value="2" /><font size="5">&nbsp;B </font></span>
					<span id="C" style="width:40px;display:-moz-inline-box;display:inline-block;color:black;"><input type="checkbox" id="SC" name="KEY[]" value="4" /><font size="5">&nbsp;C </font></span>
					<span id="D" style="width:40px;display:-moz-inline-box;display:inline-block;color:black;"><input type="checkbox" id="SD" name="KEY[]" value="8" /><font size="5">&nbsp;D </font></span>
					<span id="T" style="display:none; width:40px;display:-moz-inline-box;display:inline-block;color:black;"><input type="radio" id="ST" name="KEY[]" value="16" /><font size="5">&nbsp;T	</font></span>
					<span id="F" style="display:none; width:40px;display:-moz-inline-box;display:inline-block;color:black;"><input type="radio" id="SF" name="KEY[]" value="32" /><font size="5">&nbsp;F	</font></span>	
				  <br /><br />
					<label for="text">考察单元</label>
				<!--    	<select name="EXAM_POINT" id="EXAM_POINT" required="required" value="<?php echo set_value('EXAM_POINT'); ?>">
						<option value="A" id="A">A</option>
						<option value="B" id="B">B</option>
						<option value="C" id="C">C</option>
						<option value="D" id="D">D</option>
						<option value="T" id="T" style="display:none;">T</option>
						<option value="F" id="F" style="display:none;">F</option>
					</select> -->
					<input type="input" name="EXAM_POINT" required="required" onsubmit="return validate_form(this.SEARCH.value,this.KEYWORD.value)" value="<?php echo set_value('EXAM_POINT'); ?>"/><br />
					<br />
					<label for="text">难度设置</label>
					<input type="input" name="LEVEL" required="required" value="<?php echo set_value('LEVEL'); ?>"/><br />
					<br />
					<input type="submit" class="btn btn-default" name="submit" value="创建测试题" />
				</form>
          </div>
        </div>
      </div>
    </div>
