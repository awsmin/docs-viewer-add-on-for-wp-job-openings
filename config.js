/**
 * config file for development
 * ---------------------------
 * @package wp-job-openings
 * @subpackage wp-job-openings-docs-viewer-add-on
 * @since 1.0.0
 */

"use strict";

const path = require("path");
const assets_DIR = "";
const DEV_URL = process.env.DEV_URL || "localhost";
const NODE_ENV = process.env.NODE_ENV || "development";

module.exports = {
	previewURL: DEV_URL,
	debug: NODE_ENV == "development" ? true : false,
	style: {
		general: {
			src: "",
			dest: "",
			outputName: ""
		},
		public: {
			src: "",
			dest: "",
			outputName: ""
		},
		admin: {
			src: "",
			dest: "",
			outputName: ""
		}
	},
	scripts: {
		public: {
			src: "",
			dest: "",
			outputName: ""
		},
		admin: {
			src: "",
			dest: "",
			outputName: ""
		}
	},
	translation: {
		domain: "wp-job-openings-docs-viewer-add-on",
		package: "Docs Viewer Add-On for WP Job Openings",
		team: "AWSM innovations <hello@awsm.in>",
		dest: "./languages/wp-job-openings-docs-viewer-add-on.pot"
	}
};
