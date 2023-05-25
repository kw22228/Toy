<?php

namespace common\mail\sub;

use Closure;
use common\mail\compositions\ChargeTemplateData;
use common\mail\MailService;
use common\service\Registration;

class DepositInformation extends MailService
{
    public function __construct()
    {
        parent::__construct(new ChargeTemplateData());
    }

    protected function renderMailTemplateWithData(): string
    {
        if (empty($this->getData())) $this->setTemplateData();
        return $this->getChargeMailTemplate();
    }

    protected function getChargeMailTemplate(): string
    {
        $registration = $this->getData()->getData();
        $charge = $registration['charge'][0];
        $members = $registration['member_list'];

        return "
        <body style='margin: 0; padding: 0;'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%' >
                <tr>
                    <td>
                        <table align='center' border='0' cellpadding='0' cellspacing='0' width='850' style='border-collapse: collapse;'>
                            <tr>
                                <td>
                                    <table align='center' border='0' cellpadding='0' cellspacing='0' width='850'>
                                        <tr>
                                            <td align='center' bgcolor='#70bbd9'>
                                                <img src='https://file.mk.co.kr/wkforum/img/top_06.png' alt=' width='850' height='221' style='display:block;'>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style='padding:80px 80px 40px 80px'>
                                                <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                                    <tr>
                                                        <td bgcolor='#f7f7f7' style='padding:60px 30px 20px 30px'>
                                                            <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                                                <tr>
                                                                    <td style='padding:0 95px 0 95px;font-size:25px;font-weight:600;color:#dc1c4d;'>
                                                                        {$charge->getD_name()} 담당자 님
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style='padding:0 95px 0 95px;font-size:20px;font-weight:500;'>
                                                                        세계지식포럼 <span style='font-size:20px;color:#333333;font-weight:600;'>참가신청</span>이 접수되었습니다.
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style='font-size: 0; line-height: 0;' height='15'>&nbsp;
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style='font-size: 0; line-height: 0;' height='15'>&nbsp;
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style='font-size: 0; line-height: 0;border-bottom:1px solid #d8d8d8;' height='15'>&nbsp;
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style='font-size: 0; line-height: 0;' height='10'>&nbsp;
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style='font-size: 0; line-height: 0;' height='15'>&nbsp;
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style='font-size:15px;font-weight:600;text-align:center;vertical-align:middle;display:flex;justify-content:center;align-items:center;'>
                                                                        <span style='color:#dc1c4d;'>&#10686;</span>&nbsp;<span>참가비 입금이 확인된 후에 최종 등록이 완료됨을 알려드립니다.</span>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style='padding:0 25px 0 25px;'>
                                                            <ul style='padding-left:30px'>
                                                                <li style='color:#dc1c4d;'>
                                                                    <p style='margin-bottom:7px; margin-top:0;margin-left:-5px;font-family:\'Malgun Gothic\';font-weight:500;font-size:14px;color:#656565;line-height:1.7;'>아래 정보를 확인하신 후 수정이 필요하시면 이메일(wkf_reg@mk.co.kr, registration@wkforum.org) 또는 전화(02-2000-2620~3)로 연락주시기 바랍니다.</p>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-size: 0; line-height: 0;' height='35'>&nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-size: 0; line-height: 0;' height='15'>&nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-size: 0; line-height: 0;' height='15'>&nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-size:20px;font-weight:600;color:#dc1c4d;'>
                                                            담당자 정보
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-size: 0; line-height: 0;' height='10'>&nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table align='center' bgcolor='#e0e0e0' border='0' cellpadding='12' cellspacing='0' style='width:100%'>
                                                                <tbody>
                                                                <tr>
                                                                    <td align='center' bgcolor='#f5f5f5' style='width:35%;border-top:2px solid #363636;'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:500;color:#333333;'>이름</span></td>
                                                                    <td align='center' bgcolor='#FFFFFF' style='width:65%;border-top:2px solid #363636;text-align:left;'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:600;color:#333333;margin-left:15px;'>{$charge->getD_name()}</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td align='center' bgcolor='#f5f5f5' style='width:35%;border-top:1px solid #d8d8d8;'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:500;color:#333333;'>직장명</span></td>
                                                                    <td align='center' bgcolor='#FFFFFF' style='width:65%;border-top:1px solid #d8d8d8;text-align:left;'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:600;color:#333333;margin-left:15px;'>{$charge->getD_affiliation()}</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td align='center' bgcolor='#f5f5f5' style='width:35%;border-top:1px solid #d8d8d8;border-bottom:1px solid #d8d8d8;'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:500;color:#333333;'>전화 연락처</span></td>
                                                                    <td align='center' bgcolor='#FFFFFF' style='width:65%;border-top:1px solid #d8d8d8;border-bottom:1px solid #d8d8d8;text-align:left;'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:600;color:#333333;margin-left:15px;'>{$charge->getD_phone()}</span></td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-size: 0; line-height: 0;' height='35'>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-size: 0; line-height: 0;' height='15'>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-size:20px;font-weight:600;color:#dc1c4d;'>결제 정보</td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-size: 0; line-height: 0;' height='10'>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table align='center' bgcolor='#e0e0e0' border='0' cellpadding='12' cellspacing='0' style='width:100%'>
                                                                <tbody>
                                                                <tr>
                                                                    <td align='center' bgcolor='#f5f5f5' style='width:35%;border-top:2px solid #363636;'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:500;color:#333333;'>등록카테고리</span></td>
                                                                    <td align='center' bgcolor='#FFFFFF' style='width:65%;border-top:2px solid #363636;text-align:left;'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:600;color:#333333;margin-left:15px;'>" . Registration::REG_NAME[$this->getLang()][$members[0][0]->getRegistry_cost_num()] . "</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td align='center' bgcolor='#f5f5f5' style='width:35%;border-top:1px solid #d8d8d8;'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:500;color:#333333;'>�깅줉�몄썝��</span></td>
                                                                    <td align='center' bgcolor='#FFFFFF' style='width:65%;border-top:1px solid #d8d8d8;text-align:left;'>
                                                                        <span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:600;color:#333333;margin-left:15px;'></span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td align='center' bgcolor='#f5f5f5' style='width:35%;border-top:1px solid #d8d8d8;'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:500;color:#333333;'>李멸�鍮�</span></td>
                                                                    <td align='center' bgcolor='#FFFFFF' style='width:65%;border-top:1px solid #d8d8d8;text-align:left;'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:600;color:#333333;margin-left:15px;'></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td align='center' bgcolor='#f5f5f5' style='width:35%;border-top:1px solid #d8d8d8;border-bottom:1px solid #d8d8d8;'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:500;color:#333333;'>寃곗젣諛⑸쾿</span></td>
                                                                    <td align='center' bgcolor='#FFFFFF' style='width:65%;border-top:1px solid #d8d8d8;border-bottom:1px solid #d8d8d8;text-align:left;'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:600;color:#333333;margin-left:15px;'></span></td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-size: 0; line-height: 0;' height='5'>&nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <ul style='padding-left:15px'>
                                                                <li style='font-size:10px;color:#dc1c4d;'>
                                                                    <p style='margin-bottom:7px; margin-top:0;font-family:\'Malgun Gothic\';font-weight:500;font-size:14px;color:#656565;'>�좎씤���곸옄�� 寃쎌슦, �대떦�섎뒗 利앸튃 �쒕쪟瑜� �대찓��(wkf_reg@mk.co.kr, registration@wkforum.org)濡� �쒖텧�섏뿬 二쇱떆湲� 諛붾엻�덈떎.</p>
                                                                </li>
                                                                <li style='font-size:10px;color:#dc1c4d;'>
                                                                    <p style='margin-bottom:7px; margin-top:0;font-family:\'Malgun Gothic\';font-weight:500;font-size:14px;color:#656565;'>���� �↔툑 �섏닔猷뚮뒗 李멸��� 遺��댁엯�덈떎.</p>
                                                                </li>
                                                                <li style='font-size:10px;color:#dc1c4d;'>
                                                                    <p style='margin-bottom:7px; margin-top:0;font-family:\'Malgun Gothic\';font-weight:500;font-size:14px;color:#656565;'>�낃툑�덉젙�쇨퉴吏� 李멸�鍮꾨� �⑸��섏� �딆� 寃쎌슦 �좎껌�� �먮룞 痍⑥냼�섎뒗 �� �묓빐 遺��곷뱶由쎈땲��.</p>
                                                                </li>
                                                                <li style='font-size:10px;color:#dc1c4d;'>
                                                                    <p style='margin-bottom:7px; margin-top:0;font-family:\'Malgun Gothic\';font-weight:500;font-size:14px;color:#656565;'>李멸�鍮� �꾩븸 �⑸�媛� �뺤씤 �� �� 理쒖쥌 �깅줉�꾨즺 �덈궡 硫붿씪�� 諛쒖넚�⑸땲��.</p>
                                                                </li>
                                                                <li style='font-size:10px;color:#dc1c4d;'>
                                                                    <p style='margin-bottom:7px; margin-top:0;font-family:\'Malgun Gothic\';font-weight:500;font-size:14px;color:#656565;'>留뚯씪 �⑸� �� 1二쇱씪 �댁뿉 �대찓�쇱쓣 諛쏆� 紐삵븯�⑤떎硫� �щТ援�(02-2000-2620~3)濡� �곕씫 遺��곷뱶由쎈땲��.</p>
                                                                </li>
                                                                <li style='font-size:10px;color:#dc1c4d;'>
                                                                    <p style='margin-bottom:7px; margin-top:0;font-family:\'Malgun Gothic\';font-weight:500;font-size:14px;color:#656565;'>�꾨줈洹몃옩�� 二쇱턀痢≪쓽 �ъ젙�� �곕씪 蹂�寃쎈맆 �� �덉뒿�덈떎.</p>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-size: 0; line-height: 0;' height='30'>&nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-size: 0; line-height: 0;' height='5'>&nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-size:20px;font-weight:600;color:#dc1c4d;'>
                                                            �섎텋 諛� 痍⑥냼 �뺤콉
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-size: 0; line-height: 0;' height='5'>&nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table align='center' bgcolor='#e0e0e0' border='0' cellpadding='12' cellspacing='0' style='width:100%'>
                                                                <tbody>
                                                                <tr>
                                                                    <td align='center' bgcolor='#f5f5f5' style='width:50%;border-top:2px solid #363636;margin-top:2px;border-right:1px solid #d8d8d8;text-align:center'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:600;color:#333333;'>2022�� 9�� 8�� 源뚯�</span></td>
                                                                    <td align='center' bgcolor='f5f5f5' style='width:50%;border-top:2px solid #363636;text-align:center;'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:600;color:#333333;margin-left:15px;'>2022�� 9�� 9�� �댄썑</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td align='center' bgcolor='#FFFFFF' style='width:50%;border-top:1px solid #d8d8d8;border-bottom:1px solid #d8d8d8;text-align:center;border-right:1px solid #d8d8d8;'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:600;color:#333333;'>�섎텋媛��� (�섏닔猷� �쒖쇅)</span></td>
                                                                    <td align='center' bgcolor='FFFFFF' style='width:50%;border-top:1px solid #d8d8d8;border-bottom:1px solid #d8d8d8;text-align:center;'><span style='font-family:\'Malgun Gothic\';font-size:15px;font-weight:600;color:#333333;margin-left:15px;'>�섎텋遺덇�</span></td>
                                                                </tr>

                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-size: 0; line-height: 0;' height='5'>&nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <ul style='padding-left:15px'>
                                                                <li style='font-size:10px;color:#dc1c4d;'>
                                                                    <p style='margin-bottom:7px; margin-top:0;font-family:\'Malgun Gothic\';font-weight:500;font-size:14px;color:#656565;'>�좎껌 痍⑥냼 諛� �섎텋�� �먰븯�쒕뒗 寃쎌슦, �щТ援�(02-2000-2620~3)�쇰줈 �곕씫 二쇱떊 �� �섎텋�붿껌�쒕� �대찓��(wkf_reg@mk.co.kr, registration@wkforum.org)濡� 蹂대궡二쇱떆湲� 諛붾엻�덈떎.</p>
                                                                </li>
                                                                <li style='font-size:10px;color:#dc1c4d;'>
                                                                    <p style='margin-bottom:7px; margin-top:0;font-family:\'Malgun Gothic\';font-weight:500;font-size:14px;color:#656565;'>李멸�鍮� �섎텋�� �됱궗 醫낅즺 �� 吏꾪뻾�⑸땲��.</p>
                                                                </li>
                                                                <li style='font-size:10px;color:#dc1c4d;'>
                                                                    <p style='margin-bottom:7px; margin-top:0;font-family:\'Malgun Gothic\';font-weight:500;font-size:14px;color:#656565;'>�섎텋 �� 諛쒖깮�섎뒗 �섏닔猷뚮뒗 李멸��� 遺��댁엯�덈떎.</p>
                                                                </li>

                                                            </ul>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td style='font-size: 0; line-height: 0;' height='35'>&nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style='font-size: 0; line-height: 0;' height='15'>&nbsp;
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align='center'>
                                                <img src='https://file.mk.co.kr/wkforum/img/footer_kor.png'  usemap='#link' alt=' width='850' height='194' style='display:block;'>
                                                <map name='link'>
                                                    <area shape='rect' coords='276,104,569,145' target='_blank' href='http://wkforum.org/WKF7/2022/kr/' style='outline:0;'></map>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>
        </body>
        ";
    }
}
