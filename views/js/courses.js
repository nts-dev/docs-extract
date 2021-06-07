document_ribbon = a.attachRibbon({
    iconset: "awesome",
    items: [
        {
            type: "block", text: "Course document", text_pos: "top", mode: "cols",
            list: [
                {id: "auth", type: "button", text: "Add Key", img: "fas fa-key", imgdis: "fas fa-key"},
                {type: "newLevel"},
                {id: "new", type: "button", text: "New", img: "fas fa-file-import", imgdis: "fas fa-file-import"},
                {type: "newLevel"},

                {id: "delete", type: "button", text: "Delete", img: "fa fa-trash", imgdis: "fa fa-trash"},
                {type: "newLevel"},
                {id: "update_document", type: "button", text: "Update", img: "fa fa-edit", imgdis: "fa fa-edit",},
                {type: "newLevel"},
                {
                    id: "export",
                    type: "button",
                    text: "Export",
                    img: "fas fa-file-export",
                    imgdis: "fas fa-file-export"
                },
                {type: "newLevel"},
                {id: "restore", type: "button", text: "Restore", img: "fas fa-undo-alt", imgdis: "fas fa-undo-alt"},

                {type: "newLevel"},
                {id: "backup", type: "button", text: "Backup", img: "fas fa-redo-alt", imgdis: "fas fa-redo-alt"},
                {type: "newLevel"},
                {
                    id: "sort",
                    type: "button",
                    text: "Sort",
                    img: "fas fa-sort-numeric-up",
                    imgdis: "fas fa-sort-numeric-up"
                },
            ]
        },
    ]
});

document_ribbon.attachEvent('onClick', onDocumentRibbonClick);

 grid_1 = a.attachGrid();

grid_1.setSkin('dhx_web');
grid_1.setImagesPath(DHTMLXPATH + 'skins/web/imgs/');
grid_1.setHeader(["ID", "Name","Remote ID"]);
grid_1.setColTypes("tree,ro,ro");
grid_1.setColSorting('str,str,str');
grid_1.setInitWidthsP('30,*,20');
grid_1.enableCollSpan(true);
grid_1.init();
grid_1.load(baseURL + 'controller/documents.php?action=1');
// grid_1.expandAll(true);
grid_1.attachEvent('onRowSelect', onGrid1RowSelect);

function onDocumentRibbonClick(id) {

    if (id === 'new') {
        openUploadWindow(0, 0);
    }
    if (id === 'auth') {
        authenticateWindow();
    }
    if (id === 'delete') {

        if (doc_id == null) {
            dhtmlx.alert({
                type: "alert-error",
                text: "No Course Selected.",
                title: "Error!"
            });
            return;
        }

        deleteCourse(doc_id, doc_name);
    }

    if (id === 'export') {

        if (doc_id == null) {
            dhtmlx.alert({
                type: "alert-error",
                text: "No Course Selected.",
                title: "Error!"
            });
            return;
        }
        exportToMoodle(doc_id);
    }

    if (id === 'sort') {
        grid_1.sortRows(0, "int", "asc");
    }

    if (id === 'update_document') {

        if (doc_id == null) {
            dhtmlx.alert({
                type: "alert-error",
                text: "No Course Selected.",
                title: "Error!"
            });
            return;
        }
        updateCourseDocument(doc_id);
    }

    if (id === 'restore') {

        if (doc_id == null) {
            dhtmlx.alert({
                type: "alert-error",
                text: "No Course Selected.",
                title: "Error!"
            });
            return;
        }
        openCourseHistoryWindow(doc_id);
    }

    if (id === 'backup') {

        main_layout.progressOn();
        if (!doc_id) {
            dhtmlx.alert({
                title: 'Warning',
                text: 'Select a course to backup'
            });
            main_layout.progressOff();
            return;
        }
        $.get(baseURL + "controller/export_moodle.php?action=1&id=" + doc_id + "&update=1", function (data) {

            if (!data.response) {
                dhtmlx.alert({
                    title: 'Warning',
                    text: data.text
                });
                main_layout.progressOff();
                return;
            }

            $.get(baseURL + "controller/documents.php?action=7&version=" + data.version + "&file_name=" + data.file_name + "&docid=" + data.docid, function (data) {

                main_layout.progressOff();
                dhtmlx.message({
                    title: 'Success',
                    expire: 2000,
                    text: data.text
                });

            }, "json");


        }, "json");


    }
}

function onGrid1RowSelect(id, ind) {

    doc_id = id;


    grid_2.clearAndLoad(baseURL + 'controller/chapters.php?action=1&id=' + id);
    tab_2.detachObject(true);


    $.get(baseURL + "controller/documents.php?action=14&id=" + id, function (data) {
        doc_name = data.title;
        doc_url = data.url;
        description = data.details;
        course_form.setItemValue("title", data.title);
        course_form.setItemValue("details", description);
        course_form.setItemValue("url", doc_url);
        course_form.setItemValue("local_id", data.local_id);
        course_form.setItemValue("emp_id", data.emp_id);
        course_form.setItemValue("date_time", data.date_time);
        course_form.setItemValue("server", data.server);
    }, "json");
    tab_2.progressOn();
    $.get(baseURL + "controller/documents.php?action=2&id=" + id, function (data) {
        tab_2.attachHTMLString(data);
        tab_2.showInnerScroll();
        tab_2.progressOff();
    }, "json");


    grid_archive.clearAndLoad(baseURL + 'controller/achived_chapters.php?action=1&id=' + id);
}

function openUploadWindow(reimport, doc_id) {
    var windows = new dhtmlXWindows();
    var window_4 = windows.createWindow('window_4',0, 0, myWidth * 0.3, myHeight * 0.88)
    window_4.setText('Import Document');
    window_4.center();

    var formData = [
        {
            type: "settings",
            position: "label-left",
            labelWidth: myWidth * 0.09,
            inputWidth: myWidth * 0.18,
            offsetLeft: myWidth * 0.003
        },
        {
            type: "fieldset",
            label: "Select Export Server",
            labelInline: true,
            width: myWidth * 0.27,
            list: [
                {
                    type: "combo",
                    label: "Server  ",
                    name: "server",
                    labelWidth: myWidth * 0.1,
                    inputWidth: myWidth * 0.1,
                },

            ]
        },
        {
            type: "fieldset",
            label: "Enter document link and Authentication Key",
            iconset: "awesome",
            width: myWidth * 0.27,
            list: [{
                type: "input",
                name: "url",
                inputWidth: myWidth * 0.24, required: true,
                note: {text: "Enter your google document url here."}
            },
                {
                    type: "label", labelWidth: myWidth * 0.15
                },
                {type: "newcolumn"},
                {
                    type: "combo",
                    label: "Authentication Key  ",
                    name: "key",
                    labelWidth: myWidth * 0.1,
                    inputWidth: myWidth * 0.1,
                    note: {text: "Select Authentication Key here."}
                },
            ]
        },
        {
            type: "fieldset",
            label: "Drag And Drop Google Document zip/ms word file here",
            iconset: "awesome",
            width: myWidth * 0.27,
            list: [{
                type: "upload",
                name: "myFiles",
                inputWidth: myWidth * 0.2,
                autoStart: true,
                swfPath: baseURL + "controller/uploader.swf",
                swfUrl: baseURL + "controller/upload.php",
                autoRemove: true,
            }]
        },
        {
            type: "fieldset",
            label: "Description ",
            labelInline: true,
            width: myWidth * 0.27,
            list: [
                {
                    type: "input", name: "details", label: "Course Details", value: "", inputWidth: myWidth * 0.2,
                    value: "", rows: 3,
                    note: {text: "Describe your course."}
                },
            ]
        },

        {
            type: "label", labelWidth: myWidth * 0.27, list: [
                {
                    type: "label", labelWidth: myWidth * 0.15
                },
                {type: "newcolumn"},
                {type: "button", name: "import", value: "Import", icon: "fa fa-download", imgdis: "fa fa-download"},
                {type: "newcolumn"},
                {type: "button", name: "cancel", value: "Cancel"},
            ]
        },
    ];

    var form_2 = window_4.attachForm(formData);
    var combo_server = form_2.getCombo("server");
    var authKey = form_2.getCombo("key");
    window_4.progressOn();
    if (reimport) {
        $.get(baseURL + "controller/documents.php?action=14&id=" + doc_id, function (data) {

            form_2.setItemValue("url", data.url);
            form_2.setItemValue("details", data.details);

        }, "json");
    }

    combo_server.load(baseURL + "controller/chapters.php?action=14&id=" + doc_id, function () {
		server_id = combo_server.getSelectedValue();
		
        window_4.progressOff();
        if (!server_id) {
            dhtmlx.alert({
                title: 'Error',
                expire: 2000,
                text: "Please add Moodle server to proceed!"
            });
        }
    });

    authKey.load(baseURL + "controller/chapters.php?action=17&id=" + doc_id, function () {
        var key_id = authKey.getSelectedValue();
        window_4.progressOff();
        if (!key_id) {
            window_4.close();
            dhtmlx.alert({
                title: 'Error',
                expire: 2000,
                text: "Please add authentication Key to proceed!"
            });


        }

    });
		combo_server.attachEvent("onSelectionChange", function(){
			server_id = combo_server.getSelectedValue();
			
		 });


    form_2.attachEvent("onFileAdd",function(realName){
        var myUploader = form_2.getUploader("myFiles");
        myUploader.setURL("controller/upload.php?action=1&reimport=" + reimport + "&doc_id=" + doc_id + "&server=" + server_id + "&user_id=" + user_id + "&key=" + authKey.getSelectedText());
    });
    form_2.attachEvent("onUploadFile",function(realName,serverName){
        if (getExtension(realName)=='htm') {
                    var val = openUploadFolderWindow(realName);
                }
    });


    form_2.attachEvent("onUploadComplete", function (count) {
        dhtmlx.message({
            title: 'Success',
            expire: 20000,
            text:"Your File has been Uploaded and extracted "
        });
        grid_1.updateFromXML(baseURL + 'controller/documents.php?action=1');
        tocContentIframe.contentWindow.tinymce.activeEditor.setContent("");
        tab_2.detachObject(true);
        grid_2.updateFromXML(baseURL + 'controller/chapters.php?action=1&id=' + doc_id);
        grid_archive.updateFromXML(baseURL + 'controller/achived_chapters.php?action=1&id=' + doc_id);

        window_4.close();

    });

    form_2.attachEvent("onUploadFail", function (realName) {
        window_4.close();
        dhtmlx.alert({
            title: 'Error',
            expire: 2000,
            text: realName+" The course You are Trying to update Already Exist, Please reselect the course and update again!"
        });
    });


    form_2.attachEvent("onButtonClick", function (id) {
            if (id == "import") {
                var url = form_2.getItemValue('url');
                var details = form_2.getItemValue('details');
                if (url != "") {
                    let postdata = {
                        reimport: reimport,
                        doc_id: doc_id,
                        url: url,
                        details: details,
                        server: server_id,
                        user_id: user_id,
                        key: authKey.getSelectedText()
                    };
                    window_4.progressOn();
                    $.post(baseURL + "controller/upload.php?action=2", postdata, function (data) {

                        for (var item in data) {

                            if (data[item].response) {

                                if (data[item].hasPrivateIP) {
                                    openPrivateIpsWindow(data[item].urls);
                                } else {

                                    dhtmlx.message({title: 'Success', expire: 2000, text: data[item].text});
                                    if (data[item].course_id) {
                                        addingCourse(doc_id, data[item].course_id)
                                    }
                                }
                            } else {
                                dhtmlx.alert({title: data[item].errorMessage, text: data[item].text});
                            }
                        }


                        if (reimport > 0) {

                        } else {
                            addServer(server_id);
                        }
                        grid_1.updateFromXML(baseURL + 'controller/documents.php?action=1', true, true);
                        tocContentIframe.contentWindow.tinymce.activeEditor.setContent("");
                        tab_2.detachObject(true);

                        grid_2.updateFromXML(baseURL + 'controller/chapters.php?action=1&id=' + doc_id, true, true);
                        grid_archive.updateFromXML(baseURL + 'controller/achived_chapters.php?action=1&id=' + doc_id, true, true);

                        grid_2.expandAll();
                        grid_archive.expandAll();
                        window_4.progressOff();
                        window_4.close();

                    }, "json");
                } else {
                    dhtmlx.alert({
                        title: 'Missing Document!',
                        expire: 2000,
                        text: "Add a google document link or drag and upload google zip file and try again!"
                    });
                }
            }
            if (id === "cancel") {

                dhtmlx.message({
                    title: 'Success',
                    expire: 2000,
                    text: "Import Cancelled!"
                });

                window_4.close();
            }

        }
    );

}

function getExtension(filename) {
    var parts = filename.split('.');
    return parts[parts.length - 1];
}
function authenticateWindow() {
    var windows = new dhtmlXWindows();
    var window_4 = windows.createWindow('window_4', myWidth * 0.222, myHeight * 0.09, myWidth * 0.27, myHeight * 0.3)
    window_4.setText('Authenticate Documents');
    window_4.center();

    var formData = [
        {
            type: "fieldset",
            label: "Drag And Drop JSON Authentication Key File here",
            iconset: "awesome",
            width: myWidth * 0.2,
            list: [{
                type: "upload",
                name: "myFiles",
                inputWidth: myWidth * 0.2,
                autoStart: true,
                swfPath: baseURL + "controller/uploader.swf",
                swfUrl: baseURL + "controller/upload.php",
                autoRemove: true,
            }]
        }



    ];

    var form_2 = window_4.attachForm(formData);
    form_2.attachEvent("onFileAdd",function(realName){
        var myUploader = form_2.getUploader("myFiles");
        myUploader.setURL("controller/upload.php?action=4");
    });

    form_2.attachEvent("onUploadFail", function (realName) {
        window_4.close();
        dhtmlx.alert({
            title: 'Error',
            expire: 2000,
            text: realName+ " Error Occured!"
        });
    });
    form_2.attachEvent("onUploadComplete", function (count) {
        dhtmlx.message({
            title: 'Success',
            expire: 20000,
            text:"Your credential File has been Uploaded Successfully"
        });


        window_4.close();

    });


}
function openPrivateIpsWindow(ips) {
    var windows = new dhtmlXWindows();
    var window_4 = windows.createWindow('window_4', 0, 0, myWidth * 0.3, myHeight * 0.56)
    window_4.setText('Private Ips');
    window_4.center();


    // window_4.close();
    // return true;


}
function openUploadFolderWindow(docname) {
    var windows = new dhtmlXWindows();
    var window_4 = windows.createWindow('window_4', 0, 0, myWidth * 0.3, myHeight * 0.56)
    window_4.setText('Import Document');
    window_4.center();
    var name = docname.replace(".htm", "_files");
    var formData = [
        {
            type: "settings",
            position: "label-left",
            labelWidth: myWidth * 0.09,
            inputWidth: myWidth * 0.18,
            offsetLeft: myWidth * 0.003
        },
        {
            type: "label",
            label: "Select and upload all files used in the MS word files ie. files in  " + name + " Here!, if you did not use any file(images, shapes, etc  in the document, click Continue...",
            iconset: "awesome",
            width: myWidth * 0.27,
        },
        {
            type: "fieldset",
            label: "Select  folder",
            iconset: "awesome",
            width: myWidth * 0.27,
            list: [{
                type: "upload",
                name: "files",
                inputWidth: myWidth * 0.2,
                autoStart: true,
                swfPath: baseURL + "controller/uploader.swf",
                swfUrl: baseURL + "controller/upload.php",
                autoRemove: true,
            }]
        },
        {
            type: "label", labelWidth: myWidth * 0.27, list: [
                {
                    type: "label", labelWidth: myWidth * 0.15
                },
                {type: "newcolumn"},
                {type: "button", name: "continue", value: "Continue", icon: "fa fa-download", imgdis: "fa fa-download"},
                {type: "newcolumn"},
                {type: "button", name: "cancel", value: "Cancel"},
            ]
        },
    ];
    var formFolder = window_4.attachForm(formData);

    var myUploader = formFolder.getUploader("files");
    var folderName = name.replace("_files", "");
         myUploader.setURL("controller/upload.php?action=3&folder="+ folderName);
         status = myUploader.getStatus();
    formFolder.attachEvent("onUploadComplete", function (count) {
            dhtmlx.message({
            title: 'Success',
            expire: 2000,
            text: count+ " File  Uploaded Successfully"
        });
        if(status==0){
            window_4.close();
        }

    });
    formFolder.attachEvent("onButtonClick", function (id) {
        if (id === "cancel") {
            dhtmlx.message({
                title: 'Success',
                expire: 2000,
                text: "Import Cancelled!"
            });
            window_4.close();
        }
        if (id === "continue") {

            dhtmlx.message({
                title: 'Success',
                expire: 20000,
                text: "Proceeding with upload...!"
            });
            window_4.close();
            return true;
        }
    });
}

function updateServer(doc_id, id) {

    $.get(baseURL + "controller/documents.php?action=12&doc_id=" + doc_id + "&id=" + id, function (data) {
        main_layout.progressOff();
        if (data.response) {
            dhtmlx.message({
                title: 'Success',
                expire: 5000,
                text: data.text
            });
        } else {
            dhtmlx.alert({
                title: 'Warning',
                text: data.text
            });
        }
    }, "json");
}

function addServer(id) {

    // main_layout.progressOn();
    $.get(baseURL + "controller/documents.php?action=13&id=" + id, function (data) {
        main_layout.progressOff();

        if (data.response) {

            dhtmlx.message({
                title: 'Success',
                expire: 5000,
                text: data.text
            });
        } else {
            dhtmlx.alert({
                title: 'Warning',
                text: data.text
            });
        }
    }, "json");
}

function documentExists(moodle_course_id, document_id, doc_name) {

    dhtmlx.confirm({
        title: "Document Exists in Moodle!",
        type: "confirm-warning",

        text: doc_name + " Already Exists in Moodle! Do you want to overwrite it in moodle?",
        callback: function (ok) {

            if (ok) {
                let postdata = {
                    course_id: moodle_course_id,
                    document_id: document_id,
                    doc_name: doc_name
                };
                main_layout.progressOn();
                $.post(baseURL + "controller/export_moodle.php?action=3", postdata, function (data) {
                    main_layout.progressOff();
                    dhtmlx.message({
                        title: 'Success',
                        expire: 3000,
                        text: data.text
                    });
                }, "json");

            } else {
                dhtmlx.message({
                    title: 'Success',
                    expire: 2000,
                    text: "Process cancelled"
                });
            }
        }
    });
}

function documentRestore(course_id, doc_name, window_6) {


    dhtmlx.confirm({
        title: "Restore Course in Moodle!",
        type: "confirm-warning",

        text: "Do you want to Restore the selected version in Moodle?",
        callback: function (ok) {

            if (ok) {
                window_6.close();
                let postdata = {
                    course_id: course_id,
                    doc_name: doc_name
                };
                main_layout.progressOn();
                $.post(baseURL + "controller/export_moodle.php?action=4", postdata, function (data) {
                    main_layout.progressOff();
                    dhtmlx.message({
                        title: 'Success',
                        expire: 3000,
                        text: data.data.text
                    });
                }, "json");

            } else {
                dhtmlx.message({
                    title: 'Success',
                    expire: 2000,
                    text: "Process cancelled"
                });
            }
        }
    });
}

function exportToMoodle(doc_id) {
    main_layout.progressOn();
    let postdata = {
        id: doc_id,
        update: false,
        url: doc_url,
        details: description,

    };
    $.post(baseURL + "controller/export_moodle.php?action=1", postdata, function (data) {
        main_layout.progressOff();

        for (var item in data) {

            if (data[item].response) {

                if (data[item].hasCourseid) {
                    documentExists(data[item].course_id, doc_id, data[item].course_name);
                } else {
                    dhtmlx.message({title: 'Success', expire: 3000, text: data[item].text});

                    if (data[item].course_id) {
                        addingCourse(doc_id, data[item].course_id)
                    }
                }
            } else {
                dhtmlx.alert({title: data[item].errorMessage, text: data[item].text});
            }
        }

    }, "json");
}


function addingCourse(doc_id, course_id) {

    main_layout.progressOn();
    $.get(baseURL + "controller/export_moodle.php?action=2&course_id=" + course_id + "&id=" + doc_id, function (data) {
        main_layout.progressOff();
        for (var item in data) {
            if (data[item].response) {
                dhtmlx.message({title: 'Success', expire: 6000, text: data[item].text});
            } else {
                dhtmlx.alert({title: 'Error!', text: data[item].text});
            }
        }
        grid_2.clearAndLoad(baseURL + 'controller/chapters.php?action=1&id=' + doc_id);
        grid_archive.clearAndLoad(baseURL + 'controller/achived_chapters.php?action=1&id=' + doc_id);


    }, "json");
}

function updateCourseDocument(doc_id) {

    dhtmlx.confirm({
        title: "Update Course Document !",
        type: "confirm-warning",

        text: "Do you want to Reimport " + grid_1.cells(doc_id, 1).getValue() + " Course Document?",
        callback: function (ok) {

            if (ok) {
                openUploadWindow(1, doc_id);
            } else {
                dhtmlx.message({
                    title: 'Success',
                    expire: 2000,
                    text: "Process cancelled"
                });
            }
        }
    });
}

function deleteCourse(id, doc_name) {

    //message-related initialization
    dhtmlx.confirm({
        title: "Delete Document",
        type: "confirm-warning",

        text: "Are you sure you want to delete " + doc_name + " course?",
        callback: function (ok) {

            if (ok) {
                // var localId = grid_1.cells(id, 2).getValue();
                // if (localId != 0 || localId != '') {
                //
                // }
				main_layout.progressOn();
                $.get(baseURL + "controller/documents.php?action=5&id=" + id + "&doc_name=" + doc_name, function (data) {
                    if (data !== null) {
                        dhtmlx.message({title: 'Success', expire: 2000, text: data.text});
                              main_layout.progressOff();
                              tocContentIframe.contentWindow.tinymce.activeEditor.setContent("");
						      grid_1.deleteRow(id);
                              tab_2.detachObject(true);
                              grid_2.clearAll();
                        deleteCourseArchive(id);
                        if(data.courseid) {
                            deleteMoodle(data.courseid, doc_name,id,data.domain);
                        }
						else{
							  
						}
                    } else {
                        dhtmlx.alert({title: 'Error', text: data});
                    }
                }, "json");
            } else {
                dhtmlx.message({
                    title: 'Success',
                    expire: 2000,
                    text: "Process cancelled"
                });
            }
        }
    });
}

function deleteMoodle(courseid,doc_name,id,domain){
    dhtmlx.confirm({
        title: "Delete Course",
        type: "confirm-warning",
        text: "Do you want to delete " + doc_name + " course in moodle?",
        callback: function (ok) {
            if (ok) {
                main_layout.progressOn();
                $.get(baseURL + "controller/documents.php?action=15&id=" + id +"&courseid="+ courseid+"&domain="+ domain, function (data) {
                    main_layout.progressOff();
                    for (var item in data) {
            if (data[item].response) {
                dhtmlx.message({title: 'Success', expire: 60000, text: data[item].text});
            } else {
                dhtmlx.alert({title: 'Error!', text: data[item].text});
            }
					}
					}, "json");
                grid_1.deleteRow(id);
                tab_2.detachObject(true);
                grid_2.clearAll();
            } else {
                dhtmlx.message({
                    title: 'Success',
                    expire: 2000,
                    text: "Process cancelled!"
                });
                grid_1.deleteRow(id);
                tab_2.detachObject(true);
                grid_2.clearAll();
            }
        }
    });

}
function deleteCourseArchive(id) {

    $.get(baseURL + "controller/achived_chapters.php?action=6&id=" + id, function (data) {

        if (data.response) {
            dhtmlx.message({
                title: 'Warning',
                text: data.text
            });
            grid_archive.clearAll();

        } else {
            dhtmlx.alert({title: 'Warning', text: data.text});
        }
    }, 'json');
}

function openCourseHistoryWindow(docid) {

    var windows = new dhtmlXWindows();
    var window_6 = windows.createWindow('window_4', 0, 0, 1000, 600);
    window_6.setText('Course Versions History');
    window_4.center();

    var grid_H = window_6.attachGrid();
    grid_H.setImagePath('plugins/dhtmlxsuite5/skins/terrace/imgs/');
    grid_H.setHeader(["Version", "Time Stamp"]);
    grid_H.setColTypes("ro,ro");
    grid_H.setColSorting('str,str');
    grid_H.setInitWidths('*,*');
    grid_H.init();
    grid_H.clearAndLoad(baseURL + 'controller/documents.php?action=8&docid=' + docid);

    grid_H.attachEvent('onRowSelect', function (id, ind) {
        $.get(baseURL + "controller/export_moodle.php?action=1&id=" + docID + "&file_name=" + id, function (data) {
            main_layout.progressOff();
            if (!data.response) {
                dhtmlx.alert({
                    title: 'Warning',
                    text: data.text
                });
                return;
            }

            if (data.hasCourseid) {
                documentRestore(data.course_id, data.course_name, window_6);
                return;
            }

            dhtmlx.message({
                title: 'Success',
                expire: 5000,
                text: data.text
            });

        }, "json");
    });
}