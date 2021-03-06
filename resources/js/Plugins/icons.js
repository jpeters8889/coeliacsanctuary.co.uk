import {library, dom} from '@fortawesome/fontawesome-svg-core'
import {faBars} from "@fortawesome/free-solid-svg-icons/faBars";
import {faSearch} from "@fortawesome/free-solid-svg-icons/faSearch";
import {faTimes} from "@fortawesome/free-solid-svg-icons/faTimes";
import {faFacebookSquare} from "@fortawesome/free-brands-svg-icons/faFacebookSquare";
import {faTwitterSquare} from "@fortawesome/free-brands-svg-icons/faTwitterSquare";
import {faInstagram} from "@fortawesome/free-brands-svg-icons/faInstagram";
import {faPinterestSquare} from "@fortawesome/free-brands-svg-icons/faPinterestSquare";
import {faNewspaper} from "@fortawesome/free-regular-svg-icons/faNewspaper";
import {faPizzaSlice} from "@fortawesome/free-solid-svg-icons/faPizzaSlice";
import {faUtensils} from "@fortawesome/free-solid-svg-icons/faUtensils";
import {faStoreAlt} from "@fortawesome/free-solid-svg-icons/faStoreAlt";
import {faShoppingBasket} from "@fortawesome/free-solid-svg-icons/faShoppingBasket";
import {faAngleDoubleRight} from "@fortawesome/free-solid-svg-icons/faAngleDoubleRight";
import {faRedditSquare} from "@fortawesome/free-brands-svg-icons/faRedditSquare";
import {faTh} from "@fortawesome/free-solid-svg-icons/faTh";
import {faThList} from "@fortawesome/free-solid-svg-icons/faThList";
import {faChevronDown} from "@fortawesome/free-solid-svg-icons/faChevronDown";
import {faChevronUp} from "@fortawesome/free-solid-svg-icons/faChevronUp";
import {faExclamationCircle} from "@fortawesome/free-solid-svg-icons/faExclamationCircle";
import {faPrint} from "@fortawesome/free-solid-svg-icons/faPrint";
import {faCheck} from "@fortawesome/free-solid-svg-icons/faCheck";
import {faCaretDown} from "@fortawesome/free-solid-svg-icons/faCaretDown";
import {faStar} from "@fortawesome/free-solid-svg-icons/faStar";
import {faStarHalf} from "@fortawesome/free-solid-svg-icons";
import {faMinus} from "@fortawesome/free-solid-svg-icons/faMinus";
import {faPlus} from "@fortawesome/free-solid-svg-icons/faPlus";
import {faRssSquare} from "@fortawesome/free-solid-svg-icons/faRssSquare";

export default () => {
    // Generic
    library.add(faAngleDoubleRight);
    library.add(faBars);
    library.add(faCaretDown);
    library.add(faCheck);
    library.add(faChevronDown);
    library.add(faChevronUp);
    library.add(faExclamationCircle);
    library.add(faMinus);
    library.add(faNewspaper);
    library.add(faPizzaSlice);
    library.add(faPlus);
    library.add(faPrint);
    library.add(faRssSquare);
    library.add(faSearch);
    library.add(faShoppingBasket);
    library.add(faStar);
    library.add(faStarHalf);
    library.add(faStoreAlt);
    library.add(faTimes);
    library.add(faTh);
    library.add(faThList);
    library.add(faUtensils);

    // Social
    library.add(faFacebookSquare);
    library.add(faTwitterSquare);
    library.add(faInstagram);
    library.add(faPinterestSquare);
    library.add(faRedditSquare);

    dom.watch();
}
