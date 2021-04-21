import Vue from 'vue'

// base library
import {
    ConfigProvider,
    Layout,
    Input,
    InputNumber,
    Button,
    Switch,
    Radio,
    Checkbox,
    Select,
    Card,
    Form,
    Row,
    Col,
    Modal,
    Table,
    Tabs,
    Icon,
    Badge,
    Popover,
    Dropdown,
    List,
    Avatar,
    Breadcrumb,
    Steps,
    Spin,
    Menu,
    Drawer,
    Tooltip,
    Alert,
    Tag,
    Divider,
    DatePicker,
    TimePicker,
    Upload,
    Progress,
    Skeleton,
    Popconfirm,
    PageHeader,
    Result,
    Statistic,
    Descriptions,
    message,
    notification
} from 'ant-design-vue'

var components =  [Alert, Avatar,Badge, Breadcrumb, Button,Card,  Checkbox, Col, DatePicker, Divider, Dropdown, Form, Icon, Input, InputNumber, Layout, List, Menu, Modal, Popconfirm, Popover, Progress, Radio, Row, Select, Spin, Statistic, Steps, Switch, Table, Tabs, Tag, TimePicker, Tooltip, Upload, Drawer, Skeleton,
// ColorPicker,
    ConfigProvider, Result, Descriptions, PageHeader];

var install = function install(Vue) {
    components.map(function (component) {
        Vue.use(component);
    });

    Vue.prototype.$message = message;
    Vue.prototype.$notification = notification;
    Vue.prototype.$info = Modal.info;
    Vue.prototype.$success = Modal.success;
    Vue.prototype.$error = Modal.error;
    Vue.prototype.$warning = Modal.warning;
    Vue.prototype.$confirm = Modal.confirm;
    Vue.prototype.$destroyAll = Modal.destroyAll;
};

/* istanbul ignore if */
if (typeof window !== 'undefined' && window.Vue) {
    install(window.Vue);
}

export {  install, message, notification, Alert, Avatar,  Badge, Breadcrumb, Button, Card, Checkbox, Col, DatePicker, Divider, Dropdown, Form, Icon, Input, InputNumber, Layout, List, Menu, Modal, Popconfirm, Popover, Progress, Radio, Row, Select, Spin, Statistic, Steps, Switch, Table , Tabs, Tag, TimePicker, Tooltip, Upload, Drawer, Skeleton,
// ColorPicker,
    ConfigProvider, Result, Descriptions, PageHeader };

export default {
    install: install
};
