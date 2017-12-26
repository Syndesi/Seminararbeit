import React from 'react';
import {observer} from 'mobx-react';
import {saveAs} from 'file-saver';
import fileDialog from 'file-dialog';


@observer
export default class Heigtmap extends React.Component {

  constructor(props){
    super(props);
    this.state = {
      img: null,
      raw: null,
      map: null,
      min: 0,
      max: 1000000
    };
  }

  save(){
    var file = new File(this.state.map, 'heightmap.png', {type: "application/json;charset=utf-8"});
    saveAs(file);
  }

  load(){
    var self = this;
    fileDialog({multiple: false, accept: 'image/*'}, files => {
      var reader = new FileReader();
      reader.onload = function(e){
        self.updateCanvas(e.target.result);
      };
      reader.onerror = function(e){
        self.store.toastError('error', 'File could not read. Error code: '+e.target.error.code);
      };
      reader.readAsDataURL(files[0]);
    })
  }

  convert(){
    var ctx = this.canvas.getContext('2d');
    var data = ctx.getImageData(0,0,this.canvas.width,this.canvas.height);
    console.log(data);
    for(var i=0; i<data.data.length; i+=4){
      var r = data.data[i];
      var g = data.data[i+1];
      var b = data.data[i+2];
      var a = data.data[i+3];
      var height = -10000 + ((r * 256 * 256 + g * 256 + b) * 0.1);
      console.log(height);
      var grey = Math.round(height/1000);
      data.data[i] = grey;
      data.data[i+1] = grey;
      data.data[i+2] = grey;
      data.data[i+3] = a;
    }
    ctx.putImageData(data, 0, 0);
  }

  updateCanvas(dataURL){
    var ctx = this.canvas.getContext('2d');
    var img = new Image;
    img.onload = () => {
      this.canvas.width = img.width;
      this.canvas.height = img.height;
      ctx.drawImage(img, 0, 0);
    }
    img.src = dataURL;
  }

  render(){
    return (
      <div>
        <div className="btn btn-primary" onClick={this.load.bind(this)}>load</div>
        <div className="btn btn-primary" onClick={this.save.bind(this)}>save</div>
        <div className="btn btn-primary" onClick={this.convert.bind(this)}>convert</div>
        <canvas ref={node => this.canvas = node} />
      </div>
    );
  }
}