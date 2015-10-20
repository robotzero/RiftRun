import {Component, View, CORE_DIRECTIVES} from 'angular2/angular2';
import {status, text} from 'fetch';

@Component({
    selector: 'post'
})
@View({
    templateUrl: './components/post/post.html',
    directives: [CORE_DIRECTIVES]
})

export class Post {
    response: string;

    callPostsEndpoint() {
        this.response = null;
        window.fetch('http://localhost/v1/posts', {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
            .then(status)
            .then(text)
            .then((response) => {
            this.response = response;
        })
            .catch((error) => {
            this.response = error.message;
        });
    }

}