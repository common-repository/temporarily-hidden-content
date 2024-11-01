<div id="temporarily-hidden-content-admin">
	<figure><img src="{{PLUGIN_LOGO}}" alt="{{PLUGIN_NAME}}" /></figure>
	<div class="admin-content">
		<div class="admin-block" data-type="settings">
			<a href="#" class="dashicons-before">{{TITLE_SETTINGS}}</a>
			<div>
				<div class="temphc-settings-loading"></div>
				<form id="temphc-settings-form" method="POST">
					<div class="temphc-field" data-value="{{FORM_ACTIVE_PAGES_VALUE}}">
						<div class="temphc-field-info">
							<select name="default_color">
								{FOR FORM_DEFAULT_COLOR_OPTIONS}
									{IF {{FORM_DEFAULT_COLOR_OPTIONS.VALUE}} === {{FORM_DEFAULT_COLOR_VALUE}}}
										<option value="{{FORM_DEFAULT_COLOR_OPTIONS.VALUE}}" selected>{{FORM_DEFAULT_COLOR_OPTIONS.TEXT}}</option>
									{ELSE}
										<option value="{{FORM_DEFAULT_COLOR_OPTIONS.VALUE}}">{{FORM_DEFAULT_COLOR_OPTIONS.TEXT}}</option>
									{END IF}
								{END FOR}
							</select>
							<label>{{FORM_DEFAULT_COLOR_LABEL}}</label>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="admin-block admin-block-hidden" data-type="why">
			<a href="#" class="dashicons-before">{{TITLE_WHY}}</a>
			<div>{{BODY_WHY}}</div>
		</div>
		<div class="admin-block admin-block-hidden" data-type="about">
			<a href="#" class="dashicons-before">{{TITLE_ABOUT}}</a>
			<div>{{BODY_ABOUT}}</div>
		</div>
	</div>
	<div class="temporarily-hidden-content-admin-footer">
		<p>{{FOOTER_TEXT}}</p>
	</div>
</div>